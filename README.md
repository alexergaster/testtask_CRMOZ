# testtask_CRMOZ

### Розархівати проєкт або клонувати репозиторій:

```bash
git clone https://github.com/alexergaster/testtask_CRMOZ.git
```

### Створити файл конфігурацій та заповнити необхідні дані(БД та zoho CRM)

```bash
cp .env.example .env
```

### Згенерувати ключ
```bash
php artisan key:generate
```

### Встановити composer(потрібен файл composer.pchar):
```bash
composer install
```

### Виконати міграції:

```bash
cd server
php artisan migrate
```

### Символічні посилання

За необхідності встановити символічі посилання
```bash
php artisan storage:link
```

### Запустити сервер
```bash
php artisan serve
```

### Встановлення клієнта

```bash
cd client
npm i
npm run dev
```
