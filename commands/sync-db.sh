#/bin/bash
# How to easily sync your database to your docker virtual machine's db server:
#   1. Define the environments and its variables on web/code/config/remote.site.yml
#   2. Run it from the command line like so:
#      $ bash commands/sync-db.sh env
env=$([ "$1" ] && echo "$1" || echo "dev")
docker-compose exec web env REMOTE=$env bash -c 'eval $(ssh-agent) && ssh-add \
&& echo "Generating environment env config file..." \
&& php /opt/yaml_to_env.php \
&& source /opt/remote/$REMOTE.config \
&& echo "Dumping the database in the remote host..." \
&& ssh $user@$host "cd $root && wp db export ${alias}_${REMOTE}.sql --add-drop-table" \
&& echo "Pulling remote database dump..." \
&& scp $user@$host:$root/${alias}_${REMOTE}.sql /opt/${alias}_${REMOTE}.sql \
&& wp db import /opt/${alias}_${REMOTE}.sql --allow-root \
&& echo "Creating default local user..." \
&& wp user create localuser localuser@adkgroup.com --user_pass=mydevsite --role=administrator --allow-root
'