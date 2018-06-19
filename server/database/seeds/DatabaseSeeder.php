<?php

use Illuminate\Database\Seeder;

// Seeder code adapted from: https://laravel.com/docs/5.0/migrations#database-seeding
// Faker code adapted from: https://tutorials.kode-blog.com/laravel-5-faker-tutorial
// Seeding with foreign keys adapted from: https://laracasts.com/discuss/channels/laravel/seeding-with-foreign-keys

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed persons (also use seeded addresses)
        $this->call('PersonAddressTableSeeder');
        $this->command->info('person and address tables seeded!');

        // seed connections with seeded person ids
        $this->call('WorkConnectionTableSeeder');
        $this->command->info('workplace_connection table seeded!');
    }

}

class PersonAddressTableSeeder extends Seeder {

    private $createNumber = 25;

    public function run()
    {
        // clear out any existing table data
        DB::table('address')->delete();
        DB::table('person')->delete();

        // model factory usage adapted from: https://laravel-news.com/learn-to-use-model-factories-in-laravel-5-1
        // and here: https://laracasts.com/discuss/channels/code-review/model-factory-referencing-a-foreign-key

        // create $this->createNumber number of addresses and persons
        factory(App\Address::class, $this->createNumber)->create()
            ->each(function($address) {
                $address->person()->save(factory(App\Person::class)->make(['address_id' => $address->id]));
        });

        // non-factory way of doing it

        // initilize a new faker
        // $faker = Faker\Factory::create();

        // traverse through the create Number
        // for ($i = 0; $i < $this->createNumber; $i++) {

        //     $addressId = DB::table('address')->insertGetId([
        //         'street' => (string) $faker->streetAddress,
        //         'city' => (string) $faker->city,
        //         'state' => (string) $faker->state,
        //         'postal_code' => (string) $faker->postcode,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     ]);

        //     $personId = DB::table('person')->insertGetid([
        //         'address_id' => (int) $addressId,
        //         'first_name' => (string) $faker->firstName,
        //         'last_name' => (string) $faker->lastName,
        //         'email' => (string) $faker->unique()->safeEmail,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     ]);

        // }
    
    }

}

class WorkConnectionTableSeeder extends Seeder {

    // set the max number of colleagues a person can have
    private $maxColleagues = 5;

    public function run()
    {
        // clear out any existing table data
        DB::table('workplace_connection')->delete();

        // gather up all person ids
        $personIds = DB::table('person')->pluck('id')->toArray();

        // randomly assign person to person colleagues
        $personsAndColleagues = $this->findPersonToColleagueRelationships( (array) $personIds );

        // traverse through person and colleagues array
        foreach ($personsAndColleagues as $personId => $colleagueIds) {
            // traverse through person's colleague ids
            foreach ($colleagueIds as $colleagueId) {
                DB::table('workplace_connection')->insert([
                    'person_id' => (int) $personId,
                    'colleague_id' => (int) $colleagueId,
                ]);
            }
        }
    }

    private function findPersonToColleagueRelationships( array $personIds ): array {

        // create a new colleagues array
        // it will look like...
        // $personsAndColleagues array[
        //      (person id) => (array of colleague ids),
        //      1 => array[1,2,3],
        //      2 => array[1,2,3],
        //      (and so on)
        // ]
        $personsAndColleagues = [];

        // traverse through our persons to create their empty colleague arrays
        // note: this helps us avoid errors when counting how many colleages a person has
        // by at least having an array of colleagues to be counted at zero.
        foreach ($personIds as $personId) {
            $personsAndColleagues[$personId] = [];
        }

        // set a new array of potential colleague ids
        $potentialColleagues = $personIds;

        // traverse through person ids array to create a new array of relationships
        // - each person can only be connected to $this->maxColleagues people
        // - if person A has a colleague B, then person B has a colleague A
        // - if either a person or colleague has $this->maxColleagues or more then they cannot be connected
        // - this will output an array of PERSONS IDs which each have an array of COLLEAGUES IDs
        foreach ($personIds as $personId) {

            // randomize potential colleauges
            shuffle($potentialColleagues);

            // set our initial potential colleague key
            $colleagueKey = 0;

            // iterate through the potential colleagues while ...
            // - the person has less than max colleagues
            // - and we have not gone through all the potential colleagues
            while (
                count($personsAndColleagues[$personId]) < $this->maxColleagues && 
                ($colleagueKey < count($potentialColleagues) )
            ) {

                // - the current colleague key is a valid person
                if ( isset($potentialColleagues[$colleagueKey]) ) {

                    // set the current potential colleague id
                    $potentialColleagueId = $potentialColleagues[$colleagueKey];

                    // if...
                    // - and the current potential colleague is not the current person
                    // - and the curent person has less than max colleagues
                    // - and that potential colleauge has less than max colleagues
                    if (
                        $personId != $potentialColleagueId && 
                        count($personsAndColleagues[$personId]) <= $this->maxColleagues && 
                        count($personsAndColleagues[$potentialColleagueId]) <= $this->maxColleagues
                    ) {

                        // .. then add them to eachother's colleagues list
                        $personsAndColleagues[$personId][] = $potentialColleagueId;
                        $personsAndColleagues[$potentialColleagueId][] = $personId;

                        // if this potential colleague now has max colleagues
                        if ( count($personsAndColleagues[$potentialColleagueId]) >= $this->maxColleagues  ) {
                            // then remove them from the potential colleagues
                            // (they can no longer be a colleague of anyone else)
                            unset($potentialColleagues[$colleagueKey]);
                        }

                    }

                }

                // increment the colleague key
                $colleagueKey = $colleagueKey + 1;

            }

            // Once this person has at least 5 colleagues... 
            if ( count($personsAndColleagues[$personId]) >= $this->maxColleagues ) {

                // ... then find and remove their id from the potential colleagues
                // (they can no longer be a colleague of anyone else)
                // adapted from: https://stackoverflow.com/questions/369602/php-delete-an-element-from-an-array
                $potentialColleagueId = array_search($personId,$potentialColleagues);
                unset($potentialColleagues[$potentialColleagueId]);
            }

        }

        return (array) $personsAndColleagues;
    }

}