<?php
class Diploma
{
    // Connection
    private $conn;
    // Table
    private string $db_table = "diplomaTypes";
    // Columns
    private int $diplomaId;

    private int $categoryId;

    private string $diplomaName;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Set all values
    public function setAll($categoryId, $diplomaName)
    {
        $this->categoryId = $categoryId;
        $this->diplomaName = $diplomaName;
    }

    // Add diploma
    public function addDiploma()
    {
        $query = "INSERT INTO " . $this->db_table . " (categoryId, diplomaName) VALUES (:categoryId, :diplomaName)"; // Query to add diploma

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":categoryId", $this->categoryId);
        $stmt->bindParam(":diplomaName", $this->diplomaName);

        $stmt->execute(); // Execute query

        // check if diploma was added
        if ($stmt->rowCount() > 0) {
            $response = array(
                "status" => "success",
                "message" => "Diplôme ajouté avec succès"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Erreur lors de l'ajout du diplôme"
            );
        }

        return $response;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->db_table . " WHERE diplomaId = :id"; // Query to delete diploma

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":id", $id);

        $stmt->execute(); // Execute query

        // check if diploma was deleted
        if ($stmt->rowCount() > 0) {
            $response = array(
                "status" => "success",
                "message" => "Diplôme supprimé avec succès"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Erreur lors de la suppression du diplôme"
            );
        }

        return $response;
    }
}