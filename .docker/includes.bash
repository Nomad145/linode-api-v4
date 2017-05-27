# Aliases for common commands

alias dcomposer="docker-compose exec php composer --working-dir=/app/"
alias dphpunit="docker-compose exec php php -d memory_limit=-1 /app/vendor/bin/phpunit -c /app/"
