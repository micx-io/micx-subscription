# micx-subscription

Subscription Manager




## Configuration

| Environment Variable     | Description                                                                                  |
|--------------------------|----------------------------------------------------------------------------------------------|
| RUDL_GITDB_URL           | The full url to GitDb Service (https://some.tld or http://gitdb-service)                     |
| RUDL_GITDB_CLIENT_ID     | The client id of this service (as defined in gitdb.conf.yml in your repository)              |
| RUDL_GITDB_CLIENT_SECRET | The client secret. Can be loaded from file by prefixing: `file:/var/run/secrets/secret_name` |
| SUBSCRIPTION_SCOPE       | The scope to look up ingress object (default: subscriptions)                                 |


