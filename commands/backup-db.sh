#/bin/bash
docker-compose run mysql bash <<'EOF'
mysqldump -h $LOCALHOST -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > /adk/backups/$(date +"%Y-%m-%d_%H:%M:%S")-db.sql
exit
EOF
