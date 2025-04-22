# Zabezpieczenia i ochrona przed atakami

## Spis treści

1. [Wprowadzenie](#wprowadzenie)
2. [Uwierzytelnianie i autoryzacja](#uwierzytelnianie-i-autoryzacja)
3. [Ochrona przed popularnymi atakami](#ochrona-przed-popularnymi-atakami)
4. [Bezpieczeństwo bazy danych](#bezpieczeństwo-bazy-danych)
5. [Bezpieczeństwo infrastruktury](#bezpieczeństwo-infrastruktury)
6. [Audyt i monitorowanie](#audyt-i-monitorowanie)

## Wprowadzenie

Niniejszy dokument opisuje środki bezpieczeństwa zaimplementowane w systemie w celu ochrony przed różnymi rodzajami ataków.

## Uwierzytelnianie i autoryzacja

### Silne mechanizmy uwierzytelniania

- **Haszowanie haseł**: Wszystkie hasła są haszowane przy użyciu algorytmu Bcrypt z odpowiednim czynnikiem pracy (cost factor).
- **Weryfikacja adresu email**: Wymagana jest weryfikacja adresu email przed uzyskaniem pełnego dostępu do konta.
- **Limity prób logowania**: Zaimplementowano mechanizm ograniczający liczbę nieudanych prób logowania (rate limiting).
- **Tokeny CSRF**: Każdy formularz zawiera token CSRF, aby zapobiec atakom Cross-Site Request Forgery.

### Kontrola dostępu

- **Polityki dostępu**: Zdefiniowano szczegółowe polityki dostępu dla różnych typów użytkowników (klienci, administratorzy).
- **Izolacja interfejsów**: Interfejsy administratora i klienta są całkowicie oddzielone.

## Ochrona przed popularnymi atakami

### Cross-Site Scripting (XSS)

- **Automatyczne escapowanie**: Wszystkie dane wyjściowe są automatycznie escapowane w szablonach Blade.
- **Sanityzacja danych wejściowych**: Wszystkie dane wejściowe są sanityzowane i walidowane przed zapisem do bazy danych.

### SQL Injection

- **Prepared Statements**: Wszystkie zapytania do bazy danych wykorzystują prepared statements.
- **ORM Eloquent**: Wykorzystanie ORM Eloquent zapewnia dodatkową warstwę ochrony przed SQL Injection.
- **Parametryzowane zapytania**: Wszystkie zapytania są parametryzowane, a nie budowane przez konkatenację stringów.

### Cross-Site Request Forgery (CSRF)

- **Tokeny CSRF**: Każdy formularz zawiera unikalny token CSRF.
- **Weryfikacja tokenu**: Każde żądanie POST, PUT, DELETE jest weryfikowane pod kątem poprawności tokenu CSRF.
- **Same-Site Cookies**: Pliki cookie są oznaczone jako SameSite=Lax, aby ograniczyć przesyłanie ich w żądaniach cross-site.

### Ataki typu Brute Force

- **Rate Limiting**: Zaimplementowano ograniczenia liczby żądań dla krytycznych endpointów.

## Bezpieczeństwo bazy danych

### Ochrona danych

- **Szyfrowanie wrażliwych danych**: Wrażliwe dane są szyfrowane przed zapisem do bazy danych.
- **UUID zamiast inkrementalnych ID**: Wykorzystanie UUID zamiast inkrementalnych identyfikatorów utrudnia zgadywanie ID zasobów.

### Bezpieczeństwo zapytań

- **Indeksy**: Odpowiednie indeksy zapobiegają atakom DoS poprzez zapytania obciążające bazę danych.
- **Query Logging**: Logowanie nietypowych zapytań do celów audytowych.

## Bezpieczeństwo infrastruktury

### Bezpieczeństwo kontenerów

- **Izolacja kontenerów**: Każdy kontener ma ograniczone zasoby i uprawnienia.
- **Aktualne obrazy**: Aktualne obrazy Docker używane w celu eliminacji znanych podatności.

## Audyt i monitorowanie

### Logowanie zdarzeń

- **Strukturyzowane logi**: Logi są zapisywane w formacie strukturyzowanym, co ułatwia ich analizę.
