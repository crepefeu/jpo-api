DELIMITER //

-- Admins auto UUID
CREATE TRIGGER before_insert_admins
BEFORE INSERT ON admins
FOR EACH ROW
BEGIN
    IF NEW.id IS NULL THEN
        SET NEW.id = UUID();
    END IF;
END//

-- Sessions auto UUID
CREATE TRIGGER before_insert_sessions
BEFORE INSERT ON sessions
FOR EACH ROW
BEGIN
    IF NEW.id IS NULL THEN
        SET NEW.id = UUID();
    END IF;
END//

-- AnalyticsSnapshots auto UUID
CREATE TRIGGER before_insert_analyticsSnapshots
BEFORE INSERT ON analyticsSnapshots
FOR EACH ROW
BEGIN
    IF NEW.id IS NULL THEN
        SET NEW.id = UUID();
    END IF;
END//

-- DiplomaCategories auto UUID
CREATE TRIGGER before_insert_diplomaCategories
BEFORE INSERT ON diplomaCategories
FOR EACH ROW
BEGIN
    IF NEW.id IS NULL THEN
        SET NEW.id = UUID();
    END IF;
END//

-- DiplomaTypes auto UUID
CREATE TRIGGER before_insert_diplomaTypes
BEFORE INSERT ON diplomaTypes
FOR EACH ROW
BEGIN
    IF NEW.id IS NULL THEN
        SET NEW.id = UUID();
    END IF;
END//

-- Attendees auto UUID
CREATE TRIGGER before_insert_attendees
BEFORE INSERT ON attendees
FOR EACH ROW
BEGIN
    IF NEW.id IS NULL THEN
        SET NEW.id = UUID();
    END IF;
END//

DELIMITER ;
