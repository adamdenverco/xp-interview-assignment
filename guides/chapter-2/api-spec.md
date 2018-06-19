LinkedUp REST API
=================

## List People

`GET /api/people`

Get a list of people. Expected to return JSON in the following form:

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
---
## Get Person

`GET /api/people/{id}`

Get details about a person along with their address and colleague relations. Expected to return JSON in the following form:

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
