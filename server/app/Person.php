<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    // setting table name manually to avoid Laravel guessing it wrong
    // adapted from: https://stackoverflow.com/questions/30159257/base-table-or-view-not-found-1146-table-laravel-5
    public $table = "person";

    /*
     * function getOnePerson
     * input: person $id integer
     * output: array with person data, address, colleagues, and gravatar
     */
    public static function getOnePerson(int $id): array {

        // gather up all the data for one person
        // adapted from: https://laravel.com/docs/5.6/queries

        // call the person and the address via a left join
        // where the person id = $id
        // and limit 1
        $personArray = \DB::table('person')
            ->leftJoin('address', 'person.address_id', '=', 'address.id')
            ->select('person.*', 'address.street', 'address.city', 'address.state', 'address.postal_code')
            ->where('person.id', (int) $id)
            ->limit(1)
            ->get()
            ->toArray();

        // because the DB query returns an array with one object
        // let's cast that object as an array and make it the primary data.
        $personArray = (array) $personArray[0];

        // gather up this person's colleagues
        // use inner join so we are only gathering records for valid connnected users
        $personArray['colleagues'] = \DB::table('workplace_connection')
            ->join('person', 'workplace_connection.colleague_id', '=', 'person.id')
            ->select('person.*')
            ->where('workplace_connection.person_id', (int) $id)
            ->where('person.id', '>', 0)
            ->get()
            ->toArray();

        // cast the colleague objects as arrays for ease of use
        foreach ($personArray['colleagues'] as $key => $colleague) {
            $personArray['colleagues'][$key] = (array) $colleague;
        }

        // get the gravatar url
        $personArray['gravatar'] = Gravatar::getGravatar( (string) $personArray['email'] );

        return $personArray;

    }

    /*
     * function getAllApiFormat()
     * input: none
     * output: json string
     * example: 

        ```json
        {
        data: [
            {
                id: "1",
                firstName: "Jane",
                lastName: "Doe",
                email: "jane.doe@example.com",
                gravatarUrl: "http://gravatar/..."
            },
            {
                id: "2",
                firstName: "John",
                lastName: "Doe",
                email: "john.doe@example.com",
                gravatarUrl: "http://gravatar/..."
            }
        ]
        }
        ```

    */ 
    public static function getAllApiFormat() {

        // get the normally formatted persons
        $persons = self::all()->toArray();

        
        // now format according to the specs
        $personsOutput = (object) [ 'data' => [] ];

        foreach ($persons as $key => $person) {
            $personsOutput->data[] = (object) [
                'id' => (string) $person['id'],
                'firstName' => (string) $person['first_name'],
                'lastName' => (string) $person['last_name'],
                'email' => (string) $person['email'],
                'gravatarUrl' => (string) Gravatar::getGravatar($person['email'])
            ];
        }

        // return as a JSON string
        return json_encode($personsOutput);
    }

    /*
     * function getAllApiFormat()
     * input: none
     * output: json string
     * example: 

        `GET /api/people/{id}`

        Get details about a person along with their address and colleague relations. 
        Expected to return JSON in the following form:

        ```json
        {
            data: {
                id: "1",
                firstName: "Jane",
                lastName: "Doe",
                email: "jane.doe@example.com",
                gravatarUrl: "http://gravatar/...",
                address: {
                id: "1",
                street: "6811 Harber Creek Apt. 882",
                city: "East Catherine",
                state: "ME",
                postalCode: "71055-6986"
                },
                colleagueIds: ["2", "4"]
            }
        }
        ```
        - `address` field may be `null`.
        - `colleagueIds` field must be an array of strings representing person IDs. This array may be empty.

    */
    public static function getOnePersonApiFormat(int $id) {

        // get the normally formatted person
        $person = self::getOnePerson( (int) $id);

        // format the colleagueIds as an array of IDs
        $colleagueIds = [];
        if ( count($person['colleagues']) > 0 ) {
            foreach ($person['colleagues'] as $colleague) {
                $colleagueIds[] = $colleague['id'];
            }
        }

        // now format according to the specs
        $personOutput = (object) [
            'data' => (object) [
                'id' => (string) $person['id'],
                'firstName' => (string) $person['first_name'],
                'lastName' => (string) $person['last_name'],
                'email' => (string) $person['email'],
                'gravatarUrl' => (string) $person['gravatar'],
                'address' => (object) [
                    'id' => (string) $person['address_id'],
                    'street' => (string) $person['street'],
                    'city' => (string) $person['city'],
                    'state' => (string) $person['state'],
                    'postalCode' => (string) $person['postal_code']
                ],
                'colleagueIds' => (array) $colleagueIds
            ]
        ];

        // return as a JSON string
        return json_encode($personOutput);

    }


}
