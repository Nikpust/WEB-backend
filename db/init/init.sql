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
