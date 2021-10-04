#/bin/bash
env=$([ "$1" ] && echo "$1" || echo "dev")
docker-compose exec web env REMOTE=$env bash -c 'echo "Generating environment env config file..." \
&& php /opt/yaml_to_env.php \
&& source /opt/remote/$REMOTE.config \
&& rsync -e "ssh " -akzv  --stats --progress \
  $user@$host:$root/wp-content/uploads/ wp-content/uploads'
