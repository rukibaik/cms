# Entity Relationship Diagram

Dokumen ini dibuat dari migration di folder `database/migrations`.

## ERD Utama

```mermaid
erDiagram
    SERVICES ||--o{ SERVICE_ITEMS : "has many"
    PRICINGS ||--o{ PRICING_BENEFITS : "has many"

    HERO_SECTIONS {
        bigint id PK
        string title
        string subtitle nullable
        string button_text nullable
        string button_link nullable
        string background_image nullable
        timestamp created_at nullable
        timestamp updated_at nullable
    }

    ABOUT_SECTIONS {
        bigint id PK
        string title
        string subtitle nullable
        text description nullable
        timestamp created_at nullable
        timestamp updated_at nullable
    }

    SERVICE_SECTION_SETTINGS {
        bigint id PK
        string title
        string subtitle nullable
        string button_text nullable
        string button_link nullable
        timestamp created_at nullable
        timestamp updated_at nullable
    }

    SERVICES {
        bigint id PK
        string title
        string slug UK
        string subtitle nullable
        text description nullable
        unsigned_integer sort_order
        timestamp created_at nullable
        timestamp updated_at nullable
    }

    SERVICE_ITEMS {
        bigint id PK
        bigint service_id FK
        string title
        string subtitle nullable
        text description nullable
        string image nullable
        unsigned_integer sort_order
        timestamp created_at nullable
        timestamp updated_at nullable
    }

    PRICINGS {
        bigint id PK
        string name
        decimal price
        string button_text nullable
        string button_link nullable
        text description nullable
        boolean is_featured
        unsigned_integer sort_order
        timestamp created_at nullable
        timestamp updated_at nullable
    }

    PRICING_BENEFITS {
        bigint id PK
        bigint pricing_id FK
        string benefit
        unsigned_integer sort_order
        timestamp created_at nullable
        timestamp updated_at nullable
    }
```

## ERD Sistem Laravel

```mermaid
erDiagram
    USERS ||--o{ SESSIONS : "logical user_id"

    USERS {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at nullable
        string password
        text two_factor_secret nullable
        text two_factor_recovery_codes nullable
        timestamp two_factor_confirmed_at nullable
        string role
        boolean is_active
        string remember_token nullable
        timestamp created_at nullable
        timestamp updated_at nullable
    }

    PASSWORD_RESET_TOKENS {
        string email PK
        string token
        timestamp created_at nullable
    }

    SESSIONS {
        string id PK
        bigint user_id nullable
        string ip_address nullable
        text user_agent nullable
        longtext payload
        integer last_activity
    }

    CACHE {
        string key PK
        mediumtext value
        integer expiration
    }

    CACHE_LOCKS {
        string key PK
        string owner
        integer expiration
    }

    JOBS {
        bigint id PK
        string queue
        longtext payload
        unsigned_tiny_integer attempts
        unsigned_integer reserved_at nullable
        unsigned_integer available_at
        unsigned_integer created_at
    }

    JOB_BATCHES {
        string id PK
        string name
        integer total_jobs
        integer pending_jobs
        integer failed_jobs
        longtext failed_job_ids
        mediumtext options nullable
        integer cancelled_at nullable
        integer created_at
        integer finished_at nullable
    }

    FAILED_JOBS {
        bigint id PK
        string uuid UK
        text connection
        text queue
        longtext payload
        longtext exception
        timestamp failed_at
    }
```

## Relasi dan Constraint

| Relasi                                         | Kardinalitas                           | Constraint                                   |
| ---------------------------------------------- | -------------------------------------- | -------------------------------------------- |
| `services.id` -> `service_items.service_id`    | 1 service memiliki banyak service item | Foreign key, cascade delete                  |
| `pricings.id` -> `pricing_benefits.pricing_id` | 1 pricing memiliki banyak benefit      | Foreign key, cascade delete                  |
| `users.id` -> `sessions.user_id`               | 1 user dapat memiliki banyak session   | Relasi logis, `user_id` hanya nullable index |

## Catatan

- `hero_sections`, `about_sections`, dan `service_section_settings` dipakai seperti single-record settings melalui method `getOrCreate()` pada model.
- `services.slug`, `users.email`, dan `failed_jobs.uuid` bersifat unique.
- Tabel `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`, `password_reset_tokens`, dan `sessions` adalah tabel infrastruktur Laravel.
