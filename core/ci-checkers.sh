echo "code-sniffer checker"
echo "running vendor/bin/phpcs --standard=PSR12 src/ --ignore=Views --warning-severity=6"
vendor/bin/phpcs --standard=PSR12 src/ --ignore=Views --warning-severity=6
echo "code style checker"
echo "running composer check-style"
composer check-style
echo "psalm checker"
echo "running ./vendor/bin/psalm --no-cache"
./vendor/bin/psalm --no-cache
echo "unit test checker"
echo "running ./vendor/bin/phpunit"
# ./vendor/bin/phpunit
