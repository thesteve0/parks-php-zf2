# Parks in PHP with ZF2

## Set up gear

	rhc app create -a parks -t zend-6.6
	rhc app cartridge add -c mongodb-2.0 -a parks

## Load data

SSH into the gear and

	cd zend-5.6/var/apps/http/__default__/0/parks/1.0.0
	mongoimport -vvvv -h $OPENSHIFT_NOSQL_DB_HOST --type json -d $OPENSHIFT_APP_NAME -c parkpoints --file parks.json -u admin -p $OPENSHIFT_NOSQL_DB_PASSWORD
