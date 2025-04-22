# Instrukcja instalacji

## Wymagania wstępne

Przed rozpoczęciem instalacji upewnij się, że posiadasz:

- Docker i Docker Compose (zalecane) lub:
  - PHP 8.3
  - PostgreSQL 16
  - Node.js 20
  - Composer
  - npm

## Instalacja z użyciem Dockera (zalecana)

### Krok 1: Klonowanie repozytorium

```bash
git clone https://github.com/MreeP/BazyDanych-Relacyjne blog
cd blog
```

### Krok 2: Konfiguracja pliku .env

```bash
cp .env.example .env
```

Edytuj plik `.env` i dostosuj ustawienia bazy danych oraz inne parametry konfiguracyjne.

### Krok 3: Uruchomienie kontenerów Docker

```bash
composer install --no-dev
```

```bash
./vendor/bin/sail up -d
```

### Krok 4: Instalacja zależności

```bash
./vendor/bin/sail npm install
```

### Krok 5: Generowanie klucza aplikacji

```bash
./vendor/bin/sail artisan key:generate
```

### Krok 6: Migracja bazy danych

```bash
./vendor/bin/sail artisan migrate:fresh
```

Lub w celu załadowania również danych testowych:

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

### Krok 7: Kompilacja zasobów front-end

```bash
./vendor/bin/sail npm run build
```

## Weryfikacja instalacji

Po zakończeniu instalacji, aplikacja powinna być dostępna pod adresem:

- http://localhost:8000 - dla użytkowników
- http://localhost:8000/admin - dla administratorów
