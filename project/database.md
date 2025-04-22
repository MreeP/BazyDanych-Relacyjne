# Dokumentacja bazy danych

## Spis treści

1. [Wprowadzenie](#wprowadzenie)
2. [Schemat bazy danych](#schemat-bazy-danych)
3. [Tabele](#tabele)
    - [Użytkownicy](#użytkownicy)
    - [Posty i komentarze](#posty-i-komentarze)
    - [Polubienia](#polubienia)
    - [Systemowe](#systemowe)
4. [Relacje](#relacje)
5. [Indeksy](#indeksy)

## Wprowadzenie

System wykorzystuje bazę danych PostgreSQL 16 do przechowywania wszystkich danych aplikacji. Baza danych zawiera tabele do zarządzania użytkownikami (klientami i administratorami), postami, komentarzami oraz polubieniami, a także tabele systemowe do obsługi kolejek, sesji i pamięci podręcznej.

## Schemat bazy danych

Baza danych składa się z następujących głównych komponentów:

- Tabele użytkowników (admins, customers)
- Tabele zawartości (posts, comments)
- Tabele interakcji (likes)
- Tabele systemowe (sessions, cache, itp.)

## Tabele

### Użytkownicy

#### Tabela: admins

Przechowuje dane administratorów systemu.

| Kolumna        | Typ          | Opis                                  |
|----------------|--------------|---------------------------------------|
| id             | uuid         | Unikalny identyfikator administratora |
| name           | varchar(255) | Imię i nazwisko administratora        |
| email          | varchar(255) | Adres email (używany do logowania)    |
| password       | varchar(255) | Zahaszowane hasło                     |
| remember_token | varchar(100) | Token do funkcji "zapamiętaj mnie"    |
| created_at     | timestamp    | Data utworzenia konta                 |
| updated_at     | timestamp    | Data ostatniej aktualizacji konta     |

#### Tabela: customers

Przechowuje dane użytkowników końcowych (klientów).

| Kolumna           | Typ          | Opis                               |
|-------------------|--------------|------------------------------------|
| id                | uuid         | Unikalny identyfikator klienta     |
| name              | varchar(255) | Imię i nazwisko klienta            |
| email             | varchar(255) | Adres email (używany do logowania) |
| email_verified_at | timestamp    | Data weryfikacji adresu email      |
| password          | varchar(255) | Zahaszowane hasło                  |
| remember_token    | varchar(100) | Token do funkcji "zapamiętaj mnie" |
| created_at        | timestamp    | Data utworzenia konta              |
| updated_at        | timestamp    | Data ostatniej aktualizacji konta  |

### Posty i komentarze

#### Tabela: posts

Przechowuje posty utworzone przez użytkowników.

| Kolumna      | Typ          | Opis                              |
|--------------|--------------|-----------------------------------|
| id           | uuid         | Unikalny identyfikator posta      |
| title        | varchar(255) | Tytuł posta                       |
| slug         | varchar(255) | Przyjazny URL posta               |
| content      | text         | Treść posta                       |
| customer_id  | uuid         | Identyfikator autora (klienta)    |
| published_at | timestamp    | Data publikacji posta             |
| created_at   | timestamp    | Data utworzenia posta             |
| updated_at   | timestamp    | Data ostatniej aktualizacji posta |

#### Tabela: comments

Przechowuje komentarze do postów.

| Kolumna     | Typ       | Opis                                                  |
|-------------|-----------|-------------------------------------------------------|
| id          | uuid      | Unikalny identyfikator komentarza                     |
| content     | text      | Treść komentarza                                      |
| customer_id | uuid      | Identyfikator autora komentarza                       |
| post_id     | uuid      | Identyfikator posta, do którego odnosi się komentarz  |
| parent_id   | uuid      | Identyfikator komentarza nadrzędnego (dla odpowiedzi) |
| created_at  | timestamp | Data utworzenia komentarza                            |
| updated_at  | timestamp | Data ostatniej aktualizacji komentarza                |

### Polubienia

#### Tabela: likes

Przechowuje polubienia postów i komentarzy.

| Kolumna       | Typ          | Opis                                       |
|---------------|--------------|--------------------------------------------|
| id            | uuid         | Unikalny identyfikator polubienia          |
| customer_id   | uuid         | Identyfikator klienta, który polubił       |
| likeable_type | varchar(255) | Typ polubionego obiektu (Post lub Comment) |
| likeable_id   | uuid         | Identyfikator polubionego obiektu          |
| created_at    | timestamp    | Data utworzenia polubienia                 |
| updated_at    | timestamp    | Data ostatniej aktualizacji polubienia     |

### Systemowe

#### Tabela: sessions

Przechowuje sesje użytkowników.

| Kolumna       | Typ          | Opis                                  |
|---------------|--------------|---------------------------------------|
| id            | varchar(255) | Unikalny identyfikator sesji          |
| user_id       | uuid         | Identyfikator użytkownika             |
| ip_address    | varchar(45)  | Adres IP użytkownika                  |
| user_agent    | text         | Informacje o przeglądarce użytkownika |
| payload       | text         | Dane sesji                            |
| last_activity | integer      | Czas ostatniej aktywności             |

#### Tabela: password_reset_tokens_admin i password_reset_tokens_customer

Przechowują tokeny resetowania haseł.

| Kolumna    | Typ          | Opis                    |
|------------|--------------|-------------------------|
| email      | varchar(255) | Adres email użytkownika |
| token      | varchar(255) | Token resetowania hasła |
| created_at | timestamp    | Data utworzenia tokenu  |

## Relacje

- **customers** -> **posts**: Jeden klient może mieć wiele postów (1:N)
- **customers** -> **comments**: Jeden klient może mieć wiele komentarzy (1:N)
- **posts** -> **comments**: Jeden post może mieć wiele komentarzy (1:N)
- **comments** -> **comments**: Komentarz może mieć wiele odpowiedzi (1:N, self-referencing)
- **customers** -> **likes**: Jeden klient może mieć wiele polubień (1:N)
- **posts/comments** -> **likes**: Post lub komentarz może mieć wiele polubień (polimorficzna relacja 1:N)

## Indeksy

Baza danych wykorzystuje następujące indeksy dla optymalnej wydajności:

- Indeksy podstawowe (primary key) na kolumnach id we wszystkich tabelach
- Indeksy unikalne na kolumnach email w tabelach admins i customers
- Indeksy na kluczach obcych (customer_id, post_id, parent_id)
- Indeksy na kolumnach slug w tabeli posts dla szybkiego wyszukiwania po URL
- Indeksy na polimorficznych relacjach (likeable_type, likeable_id) w tabeli likes
