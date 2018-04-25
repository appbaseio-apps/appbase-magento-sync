# Sync Magento store to appbase.io app

## Prerequisites
### Magento

We will need the following values from the Magento Store before getting started.

```plaintext
HOSTNAME / URL
Admin username
Admin password
```

![alt text](https://i.imgur.com/prAOP1R.png "Magento2 login screen.")
For example, in the above image, these would be:

**Host**: localhost/magento2

**Username**: admin

**Password**: \*\*\*\*\*\*\*

## Step 1: Creating an Appbase.io app
![alt text](https://i.imgur.com/r6hWKAG.gif "Creating new appbase app")

Next, we will need an appbase.io app. Login to the [appbase.io dashboard](https://dashboard.appbase.io) and create a new app. You will have to get admin API key from appbase.io app. Once you have created the app, the API key should be accessible from [here](https://dashboard.appbase.io/credentials).

## Step 2: Clone the project

To start syncing, clone the following repository to your server or local machine.

```bash
git clone https://github.com/appbaseio-apps/appbase-magento-sync
cd appbase-magento-sync
```

## Step 3: Configuration

Once we have the repository, we can start configuration to sync the Magento store to appbase.io app we created in Step 1.

Configuration variables will be set in .env file. You can refer to the `.env.example` file for an example.

```bash
MAGENTO_USERNAME=
MAGENTO_PASSWORD=
MAGENTO_HOST=

APPBASE_APP=
APPBASE_API_KEY=
```

Save the `.env` file.

## Step 4: Start Syncing

To start syncing, run the following command:

```bash
php index.php
```

## Step 5: Setting up as a Cron

As an added step, we can run the above script in a cron job to keep the products in sync.

The frequency of the cron job should be set based on the frequency of updates in the products in the magento store. We will set it here for this to occur daily.


`0 0 * * * php /path/to/repository/update.php > /dev/null`

## Explanation

The syncing works with the [Appbase.io **bulk API**](https://rest.appbase.io/#1162c8a2-733f-aee0-1c57-63fc3979feeb) request and Magento GET Products **\/rest\/default\/v1\/products** API

## Note:

1. Deleted products sync is not supported at this point. For doing that you will have to delete your appbase app data and redo the sync process.

2. If a product's SKU changes, the old product will still exist in the appbase.io app. Similar to delete, you will have to rinse the appbase.io app before syncing in such a scenario.
