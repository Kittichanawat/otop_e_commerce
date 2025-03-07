CREATE TABLE tourist (
    img_id INT AUTO_INCREMENT PRIMARY KEY,
    p_id INT,
    img VARCHAR(255),
    img_show BOOLEAN,
    FOREIGN KEY (p_id) REFERENCES tourist(p_id)
);