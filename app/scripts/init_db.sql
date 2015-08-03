-- Base and ACL module
CREATE TABLE "user" (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(256) NOT NULL,
    email VARCHAR(256) NOT NULL UNIQUE,
    role VARCHAR(256),
    phone text,
    crypt_hash VARCHAR(256),
    picture VARCHAR(512),
    password_salt VARCHAR(128),
    active BOOLEAN NOT NULL DEFAULT TRUE,
    forgot_password_hash varchar(40),
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "group" (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    locked BOOLEAN NOT NULL DEFAULT FALSE,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "resource" (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    display_name VARCHAR(128),
    description VARCHAR(256),
    is_public BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "user_group" (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES "user"(ID) ON DELETE CASCADE,
    group_id BIGINT NOT NULL REFERENCES "group"(ID) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "group_resource" (
    id BIGSERIAL PRIMARY KEY,
    group_id BIGINT NOT NULL REFERENCES "group"(ID) ON DELETE CASCADE,
    resource_id BIGINT NOT NULL REFERENCES "resource"(ID) ON DELETE CASCADE,
    allow BOOLEAN NOT NULL DEFAULT false,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

-- Translation Module

CREATE TABLE "translation_language" (
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR(16) NOT NULL UNIQUE,
    name VARCHAR(64) NOT NULL,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "translation_language_user" (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES "user"(id),
    language_id BIGINT NOT NULL REFERENCES "translation_language"(id),
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "translation_language_group" (
    id BIGSERIAL PRIMARY KEY,
    group_id BIGINT NOT NULL REFERENCES "group"(id),
    language_id BIGINT NOT NULL REFERENCES "translation_language"(id),
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "translation_base" (
    id BIGSERIAL PRIMARY KEY,
    key VARCHAR(256) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "translation_value" (
    id BIGSERIAL PRIMARY KEY,
    base_id BIGINT NOT NULL REFERENCES "translation_base"(id),
    language_id BIGINT REFERENCES "translation_language"(id),
    "order" SMALLINT NOT NULL,
    value TEXT,
    translator_id BIGINT REFERENCES "user"(id),
    approved_by_id BIGINT REFERENCES "user"(id),
    approved TIMESTAMP,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "translation_comment" (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES "user"(id),
    value_id BIGINT NOT NULL REFERENCES "translation_value"(id),
    content TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

-- CMS
CREATE TABLE "cms_category" (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(200) NOT NULL UNIQUE,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "cms_page" (
    id BIGSERIAL PRIMARY KEY,
    url VARCHAR(200) NOT NULL UNIQUE,
    creator_id BIGINT NOT NULL REFERENCES "user"(id),
    category_id BIGINT NOT NULL REFERENCES "cms_category"(id) ON DELETE CASCADE,
    published TIMESTAMP,
    is_main BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "cms_page_content" (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(200),
    page_id BIGINT NOT NULL REFERENCES "cms_page"(id) ON DELETE CASCADE,
    language VARCHAR(16) NOT NULL,
    content TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP,
    CONSTRAINT un_cms_page_content_language UNIQUE (page_id, language)
);

CREATE TABLE "cms_page_group" (
    id BIGSERIAL PRIMARY KEY,
    group_id BIGINT NOT NULL REFERENCES "group"(id) ON DELETE CASCADE,
    page_id BIGINT NOT NULL REFERENCES "cms_page"(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "cms_menu" (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR UNIQUE,
    active BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "cms_menu_item" (
    id BIGSERIAL PRIMARY KEY,
    menu_id BIGINT NOT NULL REFERENCES "cms_menu"(id) ON DELETE CASCADE,
    resource_id BIGINT REFERENCES "resource"(id) ON DELETE CASCADE,
    page_id BIGINT REFERENCES "cms_page"(id) ON DELETE CASCADE,
    menu_item_id BIGINT REFERENCES "cms_menu_item"(id) ON DELETE SET NULL,
    type VARCHAR NOT NULL,
    icon VARCHAR,
    url VARCHAR,
    "order" INT,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP,
    CONSTRAINT cms_menu_item_is_valid CHECK (
        (resource_id IS NOT NULL AND page_id IS NULL AND url IS NULL) OR
        (page_id IS NOT NULL AND resource_id IS NULL AND url IS NULL) OR
        (url IS NOT NULL AND resource_id IS NULL AND page_id IS NULL)
    )
);

CREATE TABLE "cms_menu_item_content" (
    id BIGSERIAL PRIMARY KEY,
    menu_item_id BIGINT REFERENCES "cms_menu_item"(id) ON DELETE CASCADE,
    language VARCHAR(16) NOT NULL,
    text VARCHAR,
    title VARCHAR,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

CREATE TABLE "cms_menu_item_group" (
    id BIGSERIAL PRIMARY KEY,
    group_id BIGINT REFERENCES "group"(id) ON DELETE CASCADE,
    menu_item_id BIGINT REFERENCES "cms_menu_item"(id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);

