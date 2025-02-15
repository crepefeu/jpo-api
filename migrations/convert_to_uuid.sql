-- Migration script to convert integer IDs to UUIDs

START TRANSACTION;

SET FOREIGN_KEY_CHECKS=0;

-- 1. Add UUID columns to all tables
ALTER TABLE admins ADD COLUMN new_id VARCHAR(36);
ALTER TABLE sessions ADD COLUMN new_id VARCHAR(36);
ALTER TABLE analyticsSnapshots ADD COLUMN new_id VARCHAR(36);
ALTER TABLE diplomaCategories ADD COLUMN new_id VARCHAR(36);
ALTER TABLE diplomaTypes ADD COLUMN new_id VARCHAR(36);
ALTER TABLE attendees ADD COLUMN new_id VARCHAR(36);

-- 2. Generate UUIDs
UPDATE admins SET new_id = UUID();
UPDATE sessions SET new_id = UUID();
UPDATE analyticsSnapshots SET new_id = UUID();
UPDATE diplomaCategories SET new_id = UUID();
UPDATE diplomaTypes SET new_id = UUID();
UPDATE attendees SET new_id = UUID();

-- 3. Add temporary columns for foreign keys
ALTER TABLE sessions ADD COLUMN new_admin_id VARCHAR(36);
ALTER TABLE userPreferences ADD COLUMN new_admin_id VARCHAR(36);
ALTER TABLE attendees ADD COLUMN new_diploma_id VARCHAR(36);
ALTER TABLE attendees ADD COLUMN new_category_id VARCHAR(36);
ALTER TABLE diplomaTypes ADD COLUMN new_category_id VARCHAR(36);

-- 4. Update foreign key values
UPDATE sessions s 
INNER JOIN admins a ON s.adminId = a.id 
SET s.new_admin_id = a.new_id;

UPDATE userPreferences up 
INNER JOIN admins a ON up.adminId = a.id 
SET up.new_admin_id = a.new_id;

UPDATE attendees att 
INNER JOIN diplomaTypes dt ON att.diplomaId = dt.diplomaId 
SET att.new_diploma_id = dt.new_id;

UPDATE attendees att 
INNER JOIN diplomaCategories dc ON att.diplomaCategoryId = dc.id 
SET att.new_category_id = dc.new_id;

UPDATE diplomaTypes dt 
INNER JOIN diplomaCategories dc ON dt.categoryId = dc.id 
SET dt.new_category_id = dc.new_id;

-- 5. Drop old columns and constraints
ALTER TABLE sessions DROP FOREIGN KEY FK_ADMIN_ID;
ALTER TABLE userPreferences DROP FOREIGN KEY FK_USER_PREFERENCES_ADMINID;
ALTER TABLE attendees DROP FOREIGN KEY FK_DIPLOMA_ID;
ALTER TABLE attendees DROP FOREIGN KEY FK_DIPLOMA_CATEGORY_ID;
ALTER TABLE diplomaTypes DROP FOREIGN KEY FK_DIPLOMA_CATEGORY;

-- 6. Rename UUID columns to be the new primary keys and add DEFAULT UUID()
ALTER TABLE admins 
    DROP PRIMARY KEY,
    DROP COLUMN id,
    CHANGE new_id id VARCHAR(36) NOT NULL DEFAULT (UUID()),
    ADD PRIMARY KEY (id);

ALTER TABLE sessions 
    DROP PRIMARY KEY,
    DROP COLUMN id,
    CHANGE new_id id VARCHAR(36) NOT NULL DEFAULT (UUID()),
    ADD PRIMARY KEY (id);

ALTER TABLE analyticsSnapshots 
    DROP PRIMARY KEY,
    DROP COLUMN id,
    CHANGE new_id id VARCHAR(36) NOT NULL DEFAULT (UUID()),
    ADD PRIMARY KEY (id);

ALTER TABLE diplomaCategories 
    DROP PRIMARY KEY,
    DROP COLUMN id,
    CHANGE new_id id VARCHAR(36) NOT NULL DEFAULT (UUID()),
    ADD PRIMARY KEY (id);

ALTER TABLE diplomaTypes 
    DROP PRIMARY KEY,
    DROP COLUMN diplomaId,
    CHANGE new_id id VARCHAR(36) NOT NULL DEFAULT (UUID()),
    ADD PRIMARY KEY (id);

ALTER TABLE attendees 
    DROP PRIMARY KEY,
    DROP COLUMN id,
    CHANGE new_id id VARCHAR(36) NOT NULL DEFAULT (UUID()),
    ADD PRIMARY KEY (id);

-- 7. Update foreign key columns to use new UUIDs
ALTER TABLE sessions 
    DROP COLUMN adminId,
    CHANGE new_admin_id adminId VARCHAR(36) NOT NULL;

ALTER TABLE userPreferences 
    DROP COLUMN adminId,
    CHANGE new_admin_id adminId VARCHAR(36) NOT NULL;

ALTER TABLE attendees 
    DROP COLUMN diplomaId,
    DROP COLUMN diplomaCategoryId,
    CHANGE new_diploma_id diplomaId VARCHAR(36) NOT NULL,
    CHANGE new_category_id diplomaCategoryId VARCHAR(36) NOT NULL;

ALTER TABLE diplomaTypes 
    DROP COLUMN categoryId,
    CHANGE new_category_id categoryId VARCHAR(36) NOT NULL;

-- 8. Restore foreign key constraints
ALTER TABLE sessions 
    ADD CONSTRAINT FK_ADMIN_ID FOREIGN KEY (adminId) REFERENCES admins(id);

ALTER TABLE userPreferences 
    ADD CONSTRAINT FK_USER_PREFERENCES_ADMINID FOREIGN KEY (adminId) REFERENCES admins(id);

ALTER TABLE attendees 
    ADD CONSTRAINT FK_DIPLOMA_ID FOREIGN KEY (diplomaId) REFERENCES diplomaTypes(id),
    ADD CONSTRAINT FK_DIPLOMA_CATEGORY_ID FOREIGN KEY (diplomaCategoryId) REFERENCES diplomaCategories(id);

ALTER TABLE diplomaTypes 
    ADD CONSTRAINT FK_DIPLOMA_CATEGORY FOREIGN KEY (categoryId) REFERENCES diplomaCategories(id);

SET FOREIGN_KEY_CHECKS=1;

COMMIT;
