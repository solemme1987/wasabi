#/bin/bash

docker-compose exec web bash -c 'wp core install \
    --allow-root \
    --url="http://localhost:8000" \
    --title="New Site" \
    --admin_user="theadkgroup" \
    --admin_email="dummy@website.com" \
&& wp plugin delete $(wp plugin list --status=inactive --field=name --allow-root) --allow-root \
&& wp theme activate adk --allow-root \
&& wp theme delete $(wp theme list --status=inactive --field=name --allow-root | grep adk -v) --allow-root \'
