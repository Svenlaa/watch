php artisan down --render="errors::503" || exit

git reset --hard origin/master
git pull
VERSION=$(git rev-parse --short HEAD)
sed -i~ /^APP_VERSION=/s/=.*/="${VERSION}"/ .env

composer install --optimize-autoloader -no
php artisan migrate --force

pnpm i -g pnpm
pnpm i --frozen-lockfile
pnpm build

php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

php artisan up
