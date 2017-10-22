<?php

namespace Mini\Model;

use PDO;

class Model
{
    /**
     * The database connection
     * @var PDO
     */
	private $db;

    /**
     * When creating the model, the configs for database connection creation are needed
     * @param $config
     */
    function __construct($config_db)
    {
        // PDO db connection statement preparation
        $dsn = 'mysql:host=' . $config_db['host'] . ';dbname=' . $config_db['database'] . ';port=' . $config_db['port'];

        // note the PDO::FETCH_OBJ, returning object ($result->id) instead of array ($result["id"])
        // @see http://php.net/manual/de/pdo.construct.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // create new PDO db connection
        $this->db = new PDO($dsn, $config_db['username'], $config_db['password'], $options);
	}

    /**
     * Get all athletes from database
     */
    public function getAllAthletes()
    {
        $sql = "SELECT * FROM ca_athletes ORDER BY prenom_a";
        $query = $this->db->prepare($sql);
        $query->execute();
        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }
	
	/**
     * Get a song from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getAthlete($athlete_id)
    {
        $sql = "SELECT * FROM ca_athletes 
			INNER JOIN ca_resultats ON ca_athletes.id_a = ca_resultats.id_a 
			WHERE ca_resultats.id_a = :athlete_id
			LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':athlete_id' => $athlete_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }
	
	/**
     * Get a song from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getResults($athlete_id)
    {
        $sql = "SELECT *, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_a = :athlete_id 
			ORDER BY date_c ASC, tri_perf DESC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':athlete_id' => $athlete_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get activity years of an athlete
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
	 /*
    public function getAthleteYears($athlete_id)
    {
        $sql = "SELECT * FROM ca_resultats 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			WHERE ca_resultats.id_a = :athlete_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':athlete_id' => $athlete_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }*/
	
	/**
     * Get a resultats by competition id_c from database
     * @param int $competition_id of competition
     * @return mixed
     */
    public function getResultatsByCompetition($competition_id)
    {
        $sql = "SELECT *, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_c = :competition_id 
			ORDER BY ca_resultats.id_d, ca_resultats.id_cat, ca_resultats.rang_r";
        $query = $this->db->prepare($sql);
        $parameters = array(':competition_id' => $competition_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	
	/**
     * Get a song from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getRecordsAsc($athlete_id)
    {
        $sql = "SELECT *, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_a = :athlete_id 
			ORDER BY tri_perf ASC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':athlete_id' => $athlete_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get a song from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getRecordsDesc($athlete_id)
    {
        $sql = "SELECT *, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_a = :athlete_id 
			ORDER BY tri_perf DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(':athlete_id' => $athlete_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get a song from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getResultat($resultat_id)
    {
        $sql = "SELECT *, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_r = :resultat_id 
			LIMIT 1 ";
        $query = $this->db->prepare($sql);
        $parameters = array(':resultat_id' => $resultat_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }
	
	/**
     * Get a disciplines from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getDisciplines($athlete_id)
    {
        $sql = "SELECT * FROM ca_resultats 
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			WHERE ca_resultats.id_a = :athlete_id 
			GROUP BY ca_resultats.id_d";
        $query = $this->db->prepare($sql);
        $parameters = array(':athlete_id' => $athlete_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get a discipline from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getDiscipline($discipline_id)
    {
        $sql = "SELECT * FROM ca_disciplines 
			WHERE ca_disciplines.id_d = :discipline_id
			LIMIT 1 ";
        $query = $this->db->prepare($sql);
        $parameters = array(':discipline_id' => $discipline_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }
	
	/**
     * Get a disciplines from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getAllDisciplines()
    {
        $sql = "SELECT * FROM ca_resultats 
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			GROUP BY ca_resultats.id_d ";
        $query = $this->db->prepare($sql);
        $query->execute();
        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }
	
	/**
     * Get a all results from database
     * @param int $discipline_id, $sexe of results
     * @return mixed
     */
    public function getAllResultsMax($discipline_id, $sexe)
    {
        $sql = "SELECT * FROM (
		SELECT ca_resultats.id_a, MAX(ca_resultats.performance) AS max
			FROM ca_resultats
				RIGHT OUTER JOIN ca_athletes
					ON ca_resultats.id_a = ca_athletes.id_a
					AND ca_resultats.id_d = :discipline_id
				WHERE ca_athletes.sexe_a LIKE :sexe
				GROUP BY ca_resultats.id_a
				ORDER BY max DESC
	) AS tmax
		LEFT JOIN ca_resultats
			ON tmax.max = ca_resultats.performance
			AND tmax.id_a = ca_resultats.id_a
		LEFT JOIN ca_competitions
			ON ca_resultats.id_c = ca_competitions.id_c
		LEFT JOIN ca_athletes
			ON ca_resultats.id_a = ca_athletes.id_a
		WHERE ca_resultats.id_r IS NOT NULL
		GROUP BY tmax.id_a
		ORDER BY tmax.max DESC
		LIMIT 100 ";
        $query = $this->db->prepare($sql);
        $parameters = array(':discipline_id' => $discipline_id, ':sexe' => $sexe);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get a all results from database
     * @param int $discipline_id, $sexe of results
     * @return mixed
     */
    public function getAllResultsMin($discipline_id, $sexe)
    {
        $sql = "SELECT * FROM (
					SELECT ca_resultats.id_a, MIN(ca_resultats.performance) AS max
						FROM ca_resultats
						RIGHT OUTER JOIN ca_athletes 
							ON ca_resultats.id_a = ca_athletes.id_a
							AND ca_resultats.id_d = :discipline_id
						WHERE ca_athletes.sexe_a LIKE :sexe
						GROUP BY ca_resultats.id_a
						ORDER BY max ASC
					) AS tmax
				LEFT JOIN ca_resultats
					ON tmax.max = ca_resultats.performance
					AND tmax.id_a = ca_resultats.id_a
				LEFT JOIN ca_competitions
					ON ca_resultats.id_c = ca_competitions.id_c
				LEFT JOIN ca_athletes
					ON ca_resultats.id_a = ca_athletes.id_a
				WHERE ca_resultats.id_r IS NOT NULL
				GROUP BY tmax.id_a
				ORDER BY tmax.max ASC
				LIMIT 100 ";
        $query = $this->db->prepare($sql);
        $parameters = array(':discipline_id' => $discipline_id, ':sexe' => $sexe);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get a disciplines from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getPalmares($athlete_id)
    {
        $sql = "SELECT ca_palmares.id_a, ca_palmares.id_cat_c, ca_palmares.id_d, ca_palmares.id_c, ca_palmares.rang_p, ca_competitions.lieu_c, ca_competitions.date_c, ca_disciplines.nom_d FROM ca_palmares 
			RIGHT OUTER JOIN ca_competitions 
				ON ca_palmares.id_c = ca_competitions.id_c 
			RIGHT OUTER JOIN ca_disciplines 
						ON ca_palmares.id_d = ca_disciplines.id_d 
			WHERE ca_palmares.id_a = :athlete_id 
			ORDER BY ca_palmares.id_cat_c";
        $query = $this->db->prepare($sql);
        $parameters = array(':athlete_id' => $athlete_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get a disciplines from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getPalmaresChampCat($athlete_id)
    {
        $sql = "SELECT * FROM ca_palmares 
			RIGHT OUTER JOIN ca_categories_competitions 
				ON ca_palmares.id_cat_c = ca_categories_competitions.id_cat_c 
			WHERE ca_palmares.id_a = :athlete_id 
			GROUP BY ca_palmares.id_cat_c";
        $query = $this->db->prepare($sql);
        $parameters = array(':athlete_id' => $athlete_id);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	
	/**
	 * DIPLOMES
     */
	
	/**
     * Get a athletes diplomes from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getAthletesDiplomes($anneeMax, $anneeMin)
    {
        $sql = "SELECT * FROM ca_athletes 
			WHERE YEAR(ca_athletes.date_a) <= :anneeMax
				AND YEAR(ca_athletes.date_a) >= :anneeMin
			ORDER BY ca_athletes.sexe_a, ca_athletes.date_a, ca_athletes.nom_a";
        $query = $this->db->prepare($sql);
        $parameters = array(
			':anneeMin' => $anneeMin, 
			':anneeMax' => $anneeMax
		);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 60m from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function get60mDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d = 40 
				AND YEAR(ca_competitions.date_c) = :annee
				AND ca_competitions.nom_c NOT LIKE '%UBS%'
			ORDER BY tri_perf ASC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 60m from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function get80mDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d = 41 
				AND YEAR(ca_competitions.date_c) = :annee
				AND ca_competitions.nom_c NOT LIKE '%UBS%'
			ORDER BY tri_perf ASC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 60mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function get60mhDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d IN (69, 70, 71, 72, 73)
				AND YEAR(ca_competitions.date_c) = :annee
			ORDER BY tri_perf ASC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 80mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function get80mhDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d = 74
				AND YEAR(ca_competitions.date_c) = :annee
			ORDER BY tri_perf ASC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 80mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function get100mhDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d IN (75, 76)
				AND YEAR(ca_competitions.date_c) = :annee
			ORDER BY tri_perf ASC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 80mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function get1000mDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d = 49
				AND YEAR(ca_competitions.date_c) = :annee
				AND ca_competitions.nom_c NOT LIKE '%UBS%'
			ORDER BY tri_perf ASC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 80mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getHauteurDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d = 100
				AND YEAR(ca_competitions.date_c) = :annee
			ORDER BY tri_perf DESC  ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 80mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getLongueurDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d IN (102, 371)
				AND YEAR(ca_competitions.date_c) = :annee
				AND ca_competitions.nom_c NOT LIKE '%UBS%'
			ORDER BY tri_perf DESC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 80mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getPoidsDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d IN (104, 105, 106, 107, 108, 109)
				AND YEAR(ca_competitions.date_c) = :annee
			ORDER BY tri_perf DESC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 80mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getBalleDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d IN (124, 165)
				AND YEAR(ca_competitions.date_c) = :annee
				AND ca_competitions.nom_c NOT LIKE '%UBS%'
			ORDER BY tri_perf DESC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
     * Get 80mh from database
     * @param int $athlete_id id_a of athlete
     * @return mixed
     */
    public function getJavelotDipl($annee)
    {
        $sql = "SELECT ca_resultats.id_r, ca_resultats.id_a, ca_resultats.id_d, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			RIGHT OUTER JOIN ca_categories ON ca_resultats.id_cat = ca_categories.id_cat
			WHERE ca_resultats.id_d IN (120, 121, 122, 123, 174, 203)
				AND YEAR(ca_competitions.date_c) = :annee
			ORDER BY tri_perf DESC ";
        $query = $this->db->prepare($sql);
        $parameters = array(':annee' => $annee);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	
	/**
	 * CATEGORIES
     */
	 
	 public function getAthletesCategories($dateMin, $dateMax, $anneeAthlMax, $anneeAthlMin)
    {
        $sql = "SELECT ca_resultats.id_a, ca_athletes.date_a, ca_athletes.prenom_a, ca_athletes.nom_a, ca_athletes.sexe_a FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			WHERE ca_competitions.date_c <= :dateMax
				AND ca_competitions.date_c >= :dateMin
				AND (:anneeAthlMax IS NULL OR YEAR(ca_athletes.date_a) <= :anneeAthlMax)
				AND (:anneeAthlMin IS NULL OR YEAR(ca_athletes.date_a) >= :anneeAthlMin)
			GROUP BY ca_resultats.id_a
			ORDER BY ca_athletes.sexe_a, ca_athletes.date_a, ca_athletes.nom_a";
        $query = $this->db->prepare($sql);
        $parameters = array(
			':dateMin' => $dateMin, 
			':dateMax' => $dateMax,
			':anneeAthlMax' => $anneeAthlMax,
			':anneeAthlMin' => $anneeAthlMin,
		);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        return $query->fetchAll();
    }
	
	public function getDisciplinesCategories($dateMin, $dateMax, $anneeAthlMax, $anneeAthlMin)
    {
        $sql = "SELECT ca_disciplines.id_d, ca_disciplines.nom_d, ca_disciplines.tri_d FROM ca_resultats 
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			WHERE ca_competitions.date_c <= :dateMax
				AND ca_competitions.date_c >= :dateMin
				AND (:anneeAthlMax IS NULL OR YEAR(ca_athletes.date_a) <= :anneeAthlMax)
				AND (:anneeAthlMin IS NULL OR YEAR(ca_athletes.date_a) >= :anneeAthlMin)
			GROUP BY ca_resultats.id_d
			ORDER BY ca_resultats.id_d";
        $query = $this->db->prepare($sql);
        $parameters = array(
			':dateMin' => $dateMin, 
			':dateMax' => $dateMax,
			':anneeAthlMax' => $anneeAthlMax,
			':anneeAthlMin' => $anneeAthlMin,
		);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	public function getResultatsCategories($dateMin, $dateMax, $anneeAthlMax, $anneeAthlMin)
    {
        $sql = "SELECT *, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf  FROM ca_resultats
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			WHERE ca_competitions.date_c <= :dateMax
				AND ca_competitions.date_c >= :dateMin
				AND (:anneeAthlMax IS NULL OR YEAR(ca_athletes.date_a) <= :anneeAthlMax)
				AND (:anneeAthlMin IS NULL OR YEAR(ca_athletes.date_a) >= :anneeAthlMin)
			ORDER BY ca_resultats.id_a, ca_resultats.id_d, tri_perf";
        $query = $this->db->prepare($sql);
        $parameters = array(
			':dateMin' => $dateMin, 
			':dateMax' => $dateMax,
			':anneeAthlMax' => $anneeAthlMax,
			':anneeAthlMin' => $anneeAthlMin,
		);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }
	public function getResultatsCategoriesId($dateMin, $dateMax, $anneeAthlMax, $anneeAthlMin, $idAth, $idDisc, $triDisc)
    {
        $sql = "SELECT ca_resultats.id_a, ca_resultats.id_d, ca_disciplines.tri_d, ca_resultats.id_r, ca_resultats.performance, CAST(REPLACE(REPLACE(REPLACE(performance, 'h', ''), ':', ''), '.', '') AS UNSIGNED INTEGER) AS tri_perf  FROM ca_resultats
			RIGHT OUTER JOIN ca_athletes ON ca_resultats.id_a = ca_athletes.id_a 
			RIGHT OUTER JOIN ca_competitions ON ca_resultats.id_c = ca_competitions.id_c
			RIGHT OUTER JOIN ca_disciplines ON ca_resultats.id_d = ca_disciplines.id_d 
			WHERE ca_competitions.date_c <= :dateMax
				AND ca_competitions.date_c >= :dateMin
				AND (:anneeAthlMax IS NULL OR YEAR(ca_athletes.date_a) <= :anneeAthlMax)
				AND (:anneeAthlMin IS NULL OR YEAR(ca_athletes.date_a) >= :anneeAthlMin)
				AND ca_resultats.id_a = :idAth
				AND (:idDisc IS NULL OR ca_resultats.id_d = :idDisc)
			ORDER BY 
				CASE WHEN :triDisc = 'ASC' THEN tri_perf END ASC ,
				CASE WHEN :triDisc = 'DESC' THEN tri_perf END DESC ";
        $query = $this->db->prepare($sql);
        $parameters = array(
			':dateMin' => $dateMin, 
			':dateMax' => $dateMax,
			':anneeAthlMax' => $anneeAthlMax,
			':anneeAthlMin' => $anneeAthlMin,
			':idAth' => $idAth,
			':idDisc' => $idDisc,
			':triDisc' => $triDisc,
		);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . \PdoDebugger::show($sql, $parameters); exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }
}
