# Sync Magento store to appbase.io app

## Prerequisites
### Magento

```plaintext
HOSTNAME / URL
Admin username
Admin password
```

![alt text](https://i.imgur.com/prAOP1R.png "Magento2 login screen.")
For example in the above image

**Host**: localhost/magento2
**Username**: admin
**Password**: \*\*\*\*\*\*\*

## Step 1: Creating an Appbase.io app
![alt text](https://i.imgur.com/r6hWKAG.gif "Creating new appbase app")

Log in to  appbase.io dashboard, and create a new app.

For this tutorial, we will use an app called newstreamingapp.

```plaintext
Note
1. You will have to get admin API credentials from appbaseio app
2. appbase.io uses HTTP Basic Auth, a widely used protocol for a username:password based authentication.
```

## Step 2: Clone the project

To start syncing clone the repository to your server or local machine.

`git clone https://github.com/jrishabh55/appbase-magento-sync`

## Step 3: Configuration

Once we have the repository, we can start configuration to sync the Magento store to appbase.io app we created in Step 1.

Configuration variables will be set in .env file.
```
MEGENTO_USERNAME=
MEGENTO_PASSWORD=
MAGENTO_HOST=

APPBASE_SECRET=
APPBASE_APP_NAME=
```

Above variables should be set in the .env file.

## Step 4: Start Syncing
To start intial syncing the store please run the following command in the root directory of the repository.
```php
php index.php
```

## Step 5: Step Cron

To keep the data in sync you will have to create a sync project we will have to setup a cron request.

The frequency of the cron request depends on the frequency of changes in the product a general idea will be once a day.

The following cron request will run daily at 00:00

`0 0 * * * php /path/to/repository/update.php > /dev/null`

## Explanation

The syncing works with the [Appbase.io **bulk API**](https://rest.appbase.io/#1162c8a2-733f-aee0-1c57-63fc3979feeb) request and Magento GET Products **\/rest\/default\/v1\/products** API

## Note:

1. Deleted products sync is not supported at this point. For doing that you will have to delete your appbase app data and redo the sync process.
