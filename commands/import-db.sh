#/bin/bash
docker cp $1 mysql:/adk/imports/db.sql
docker-compose run mysql bash <<'EOF'
mysql -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE < /adk/imports/db.sql
exit
EOF
