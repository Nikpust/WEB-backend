CREATE TABLE IF NOT EXISTS books (
    book_id                 SERIAL              PRIMARY KEY,
    book_created_at         TIMESTAMP           NOT NULL,
    book_updated_at         TIMESTAMP           NOT NULL,
    book_name               VARCHAR(255)        NOT NULL,
    book_author             VARCHAR(255)        NOT NULL,
    book_year               INT                 NOT NULL,
    book_publisher          VARCHAR(255)        NOT NULL,
    book_isbn               VARCHAR(13)         NOT NULL UNIQUE,
    book_pages              INT                 NOT NULL,
    book_age                VARCHAR(10)         NOT NULL,
    book_release_date       DATE                NOT NULL,
    book_weight             DECIMAL(10,2)       NOT NULL,
    book_price              DECIMAL(10,2)       NOT NULL,
    book_summary            TEXT
);

CREATE TABLE IF NOT EXISTS genres (
    genre_id        SERIAL          PRIMARY KEY,
    genre_name      VARCHAR(50)     NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS book_genre (
    book_id     INT NOT NULL,
    genre_id    INT NOT NULL,
    PRIMARY KEY (book_id, genre_id),
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genres(genre_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS users (
    user_id             SERIAL              PRIMARY KEY,
    user_fullname       VARCHAR(150)        NOT NULL,
    user_email          VARCHAR(255)        NOT NULL UNIQUE,
    user_password       VARCHAR(255)        NOT NULL,
    user_role           VARCHAR(10)         NOT NULL,
    user_created_at     TIMESTAMP           NOT NULL
);

CREATE TABLE IF NOT EXISTS cart (
    user_id     INT     NOT NULL,
    book_id     INT     NOT NULL,
    PRIMARY KEY (user_id, book_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS favorites (
    user_id     INT     NOT NULL,
    book_id     INT     NOT NULL,
    PRIMARY KEY (user_id, book_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);