<?php

class nome {
    private $conn;
    private $nome;
    
    function __construct($conn, $nome = null) {
        $this->conn = $conn;
        $this->nome = $nome;
    }
    
    function get_nomi() {
        $results = array();       
        $stmt = $this->conn->query("SELECT DISTINCT nome FROM frequenza_nomi ORDER BY nome");

        while ($row = $stmt->fetch()) {
            array_push($results, $row["nome"]);
        }

        return $results;
    }
    
    function report_frequenza_nomi() {
        $results = array();
        
        if (!$stmt = $this->conn->prepare("SELECT nome, anno, numero FROM frequenza_nomi WHERE nome = ?")) {
            throw new Exception("Errore preparazione statement.");
        }

        if (!$stmt->execute(array($this->nome))) {
            throw new Exception("Errore esecuzione statement.");
        }

        while ($row = $stmt->fetch()) {
            $results[] = array(
                "nome" => $row["nome"],
                "anno" => $row["anno"],
                "numero" => number_format($row["numero"], 0, ",", ".")
            );
        }

        return $results;					
    }
}