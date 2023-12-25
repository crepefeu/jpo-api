<?php
class DiplomaCategory
{
    // Connection
    private $conn;
    // Table
    private string $db_table = "diplomaCategories";
    // Columns
    private int $id;

    private string $categoryName;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Set all values
    public function setAll($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    // Add diploma
    public function addDiplomaCategory()
    {
        $query = "INSERT INTO " . $this->db_table . " (categoryName) VALUES (:categoryName)"; // Query to add diploma

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":categoryName", $this->categoryName);

        $stmt->execute(); // Execute query

        // check if diploma was added
        if ($stmt->rowCount() > 0) {
            $response = array(
                "status" => "success",
                "message" => "Catégorie ajoutée avec succès"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Erreur lors de l'ajout de la catégorie"
            );
        }

        return $response;
    }
}