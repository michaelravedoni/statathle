<?php

/******************************* LOADING & INITIALIZING BASE APPLICATION ****************************************/

// Configuration for error reporting, useful to show every little problem during development
error_reporting(E_ALL);
ini_set("display_errors", 1);

// set a constant that holds the project's folder path, like "/var/www/".
// DIRECTORY_SEPARATOR adds a slash to the end of the path
define('ROOT', posix_getcwd() . DIRECTORY_SEPARATOR);
// set a constant that holds the project's "application" folder, like "/var/www/application".
define('APP', ROOT . 'Mini' . DIRECTORY_SEPARATOR);

// load application config (error reporting etc.)
require APP . 'config/config.php';

$configs = include(APP . 'config/config.php');

// Load Composer's PSR-4 autoloader (necessary to load Slim, Mini etc.)
require 'vendor/autoload.php';

// Initialize Slim (the router/micro framework used)
$app = new \Slim\Slim(array(

// Set the current mode
    'mode' => 'development',
// Set global variables
	'appTitle' => $configs['appTitle'],
));

// and define the engine used for the view @see http://twig.sensiolabs.org
$app->view = new \Slim\Views\Twig(['cache' => false]);
$app->view->setTemplatesDirectory("Mini/view");

$app->view->parserExtensions = [
	new \Slim\Views\TwigExtension(),
	new \Twig_Extension_Debug()
];
/******************************************* THE CONFIGS *******************************************************/

// Configs for mode "development" (Slim's default), see the GitHub readme for details on setting the environment
$app->configureMode('development', function () use ($app) {

    // pre-application hook, performs stuff before real action happens @see http://docs.slimframework.com/#Hooks
	$app->hook('slim.before', function () use ($app) {

        // SASS-to-CSS compiler @see https://github.com/panique/php-sass
        SassCompiler::run("scss/", "css/");

        // CSS minifier @see https://github.com/matthiasmullie/minify
        $minifier = new MatthiasMullie\Minify\CSS('css/style.css');
        $minifier->minify('css/style.css');

        // JS minifier @see https://github.com/matthiasmullie/minify
        // DON'T overwrite your real .js files, always save into a different file
        //$minifier = new MatthiasMullie\Minify\JS('js/application.js');
        //$minifier->minify('js/application.minified.js');
    });

    // Set the configs for development environment
    $app->config(array(
		'log.enable' => true,
        'debug' => true,
		'siteUrl'  => URL,
		'basePath' => ROOT,
		'currentUrl' => URL . $app->request->getResourceUri(),
        'database' => array(
            'db_host' => 'localhost',
            'db_port' => '8889',
            'db_name' => 'stats',
            'db_user' => 'root',
            'db_pass' => 'root'
        )
    ));
});

// Configs for mode "production"
$app->configureMode('production', function () use ($app) {

	// pre-application hook, performs stuff before real action happens @see http://docs.slimframework.com/#Hooks
    $app->hook('slim.before', function () use ($app) {

		$app->view()->appendData(array(
			'baseUrl' => 'URL',
			'currentUrl' => 'URL'.$app->request->getResourceUri()
		));

        // SASS-to-CSS compiler @see https://github.com/panique/php-sass
        SassCompiler::run("scss/", "css/");

        // CSS minifier @see https://github.com/matthiasmullie/minify
        $minifier = new MatthiasMullie\Minify\CSS('css/style.css');
        $minifier->minify('css/style.css');

        // JS minifier @see https://github.com/matthiasmullie/minify
        // DON'T overwrite your real .js files, always save into a different file
        //$minifier = new MatthiasMullie\Minify\JS('js/application.js');
        //$minifier->minify('js/application.minified.js');
    });

    // Set the configs for production environment
    $app->config(array(
		'log.enable' => false,
        'debug' => false,
		'siteUrl'  => URL,
		'basePath' => ROOT,
		'currentUrl' => URL . $app->request->getResourceUri(),
        'database' => array(
            'db_host' => '',
            'db_port' => '',
            'db_name' => '',
            'db_user' => '',
            'db_pass' => ''
        )
    ));
});

/******************************************** THE MODEL ********************************************************/

// Initialize the model, pass the database configs. $model can now perform all methods from Mini\model\model.php
$model = new \Mini\Model\Model($app->config('database'));

/************************************ THE ROUTES / CONTROLLERS *************************************************/

// GET request on homepage, simply show the view template index.twig
$app->get('/', function () use ($app, $model) {

	$athletes = $model->getAllAthletes();

	$app->render('index.twig', array(
		'athletes' => $athletes
		));
	});

// All requests on /songs and behind (/songs/search etc) are grouped here. Note that $model is passed (as some routes
// in /songs... use the model)
$app->group('/songs', function () use ($app, $model) {

    // GET request on /songs. Perform actions getAmountOfSongs() and getAllSongs() and pass the result to the view.
    // Note that $model is passed to the route via "use ($app, $model)". I've written it like that to prevent creating
    // the model / database connection in routes that does not need the model / db connection.
    $app->get('/', function () use ($app, $model) {

        $athletesCount = $model->getAmountOfSongs();
        $athletes = $model->getAllSongs();

        $app->render('songs.twig', array(
            'athletesCount' => $athletesCount,
            'athletes' => $athletes
        ));
    });

    // POST request on /songs/addsong (after a form submission from /songs). Asks for POST data, performs
    // model-action and passes POST data to it. Redirects the user afterwards to /songs.
    $app->post('/addsong', function () use ($app, $model) {

        // in a real-world app it would be useful to validate the values (inside the model)
        $model->addSong(
            $_POST["artist"], $_POST["track"], $_POST["link"], $_POST["year"], $_POST["country"], $_POST["genre"]);
        $app->redirect('/songs');
    });

    // GET request on /songs/deletesong/:song_id, where :song_id is a mandatory song id.
    // Performs an action on the model and redirects the user to /songs.
    $app->get('/deletesong/:song_id', function ($song_id) use ($app, $model) {

        $model->deleteSong($song_id);
        $app->redirect('/songs');
    });

    // GET request on /songs/editsong/:song_id. Should be self-explaining. If song id exists show the editing page,
    // if not redirect the user. Note the short syntax: 'song' => $model->getSong($song_id)
    $app->get('/editsong/:song_id', function ($song_id) use ($app, $model) {

        $song = $model->getSong($song_id);

        if (!$song) {
            $app->redirect('/songs');
        }

        $app->render('songs.edit.twig', array('song' => $song));
    });

    // POST request on /songs/updatesong. Self-explaining.
    $app->post('/updatesong', function () use ($app, $model) {

        // passing an array would be better here, but for simplicity this way it okay
        $model->updateSong($_POST['song_id'], $_POST["artist"], $_POST["track"], $_POST["link"], $_POST["year"],
            $_POST["country"], $_POST["genre"]);

        $app->redirect('/songs');
    });

    // GET request on /songs/ajaxGetStats. In this demo application this route is used to request data via
    // JavaScript (AJAX). Note that this does not render a view, it simply echoes out JSON.
    $app->get('/ajaxGetStats', function () use ($app, $model) {

        $amount_of_songs = $model->getAmountOfSongs();
        $app->contentType('application/json;charset=utf-8');
        echo json_encode($amount_of_songs);
    });

    // POST request on /search. Self-explaining.
    $app->post('/search', function () use ($app, $model) {

        $result_songs = $model->searchSong($_POST['search_term']);

        $app->render('songs.search.twig', array(
            'amount_of_results' => count($result_songs),
            'songs' => $result_songs
        ));
    });

    // GET request on /search. Simply redirects the user to /songs
    $app->get('/search', function () use ($app) {
        $app->redirect('/songs');
    });

});

// All requests on /athletes and behind (/athletes/search etc) are grouped here. Note that $model is passed (as some routes
// in /athletes... use the model)
$app->group('/athletes', function () use ($app, $model) {

    // GET request on /athletes. Perform actions getAllAthletes() and pass the result to the view.
    // Note that $model is passed to the route via "use ($app, $model)". I've written it like that to prevent creating
    // the model / database connection in routes that does not need the model / db connection.
    $app->get('/', function () use ($app, $model) {
        $athletes = $model->getAllAthletes();

        $app->render('athletes.twig', array(
            'athletes' => $athletes
        ));
	});

	// GET request on /songs/:athlete_id. Should be self-explaining. If song id exists show the editing page,
    // if not redirect the user. Note the short syntax: 'athletes' => $model->getAthlete($athlete_id)
    $app->get('/:athlete_id', function ($athlete_id) use ($app, $model) {

        $discipline_id = $app->request->params('disc');
		if (!$discipline_id) {$discipline_id = 'all';}

		$athlete = $model->getAthlete($athlete_id);
		$results = $model->getResults($athlete_id);
		$recordsAsc = $model->getRecordsAsc($athlete_id);
		$recordsDesc = $model->getRecordsDesc($athlete_id);
		$disciplines = $model->getDisciplines($athlete_id);
		$discipline = $model->getDiscipline($discipline_id);
		$palmares = $model->getPalmares($athlete_id);
		$palmaresChamp = $model->getPalmaresChampCat($athlete_id);

        if (!$athlete) {
            $app->redirect('/athletes');
        }

        $app->render('athlete.twig', array(
			'athlete' => $athlete,
			'disciplines' => $disciplines,
			'discipline' => $discipline,
			'discipline_id' => $discipline_id,
			'recordsAsc' => $recordsAsc,
			'recordsDesc' => $recordsDesc,
			'palmares' => $palmares,
			'palmaresChamp' => $palmaresChamp,
			'results' => $results
		));
    });

});

// GET request on /statistiques, simply show the view template statistiques.twig
$app->get('/resultat/:resultat_id', function ($resultat_id) use ($app, $model) {

    $resultat = $model->getResultat($resultat_id);

	$app->render('resultat.twig', array(
			'resultat_id' => $resultat_id,
			'resultat' => $resultat
	));
});

// GET request on /competitions, simply show the view template competitions.twig
$app->get('/competitions/:competition_id', function ($competition_id) use ($app, $model) {

    $resultats = $model->getResultatsByCompetition($competition_id);

	$app->render('competition.twig', array(
			'competition_id' => $competition_id,
			'resultats' => $resultats
	));
});

// GET request on /bilans, simply show the view template bilans.twig
$app->get('/bilans', function () use ($app) {
    $app->render('bilans.twig');
});

// GET request on /bilans, simply show the view template bilans.twig
$app->get('/a-propos', function () use ($app) {
    $app->render('a-propos.twig');
});

// GET request on /statistiques, simply show the view template statistiques.twig
$app->get('/statistiques', function () use ($app) {
	// redirect to id 42 (100m in the database)
    $app->redirect('statistiques/42');
});

// GET request on /statistiques/:discipline_id, simply show the view template statistiques.twig
$app->get('/statistiques/:discipline_id', function ($discipline_id = "42") use ($app, $model) {

	$sexe = $app->request->params('sexe');
	$cat = $app->request->params('cat');
	if (!$sexe) {$sexe = 'm';}

	$resultsMax = $model->getAllResultsMax($discipline_id, $sexe);
	$resultsMin = $model->getAllResultsMin($discipline_id, $sexe);
	$disciplines = $model->getAllDisciplines();
	$discipline = $model->getDiscipline($discipline_id);



    $app->render('statistiques.twig', array(
		'disciplines' => $disciplines,
		'discipline' => $discipline,
		'resultsMax' => $resultsMax,
		'resultsMin' => $resultsMin,
		'discipline_id' => $discipline_id,
		'sexe' => $sexe
	));
});

// GET request on /diplomes/:annee, simply show the view template statistiques.twig
$app->get('/diplomes/:annee', function ($annee) use ($app, $model) {

	$anneeMin = (string) $annee - 15;
	$anneeMax = (string) $annee - 10;

	$athletes = $model->getAthletesDiplomes($annee, $anneeMin, $anneeMax);
	$disc60m = $model->get60mDipl($annee);
	$disc80m = $model->get80mDipl($annee);
	$disc60mh = $model->get60mhDipl($annee);
	$disc80mh = $model->get80mhDipl($annee);
	$disc100mh = $model->get100mhDipl($annee);
	$disc1000m = $model->get1000mDipl($annee);
	$discHauteur = $model->getHauteurDipl($annee);
	$discLongueur = $model->getLongueurDipl($annee);
	$discPoids = $model->getPoidsDipl($annee);
	$discBalle = $model->getBalleDipl($annee);
	$discJavelot = $model->getJavelotDipl($annee);

    $app->render('diplomes.twig', array(
		'athletes' => $athletes,
		'annee' => $annee,
		'disc60m' => $disc60m,
		'disc80m' => $disc80m,
		'disc60mh' => $disc60mh,
		'disc80mh' => $disc80mh,
		'disc100mh' => $disc100mh,
		'disc1000m' => $disc1000m,
		'discHauteur' => $discHauteur,
		'discLongueur' => $discLongueur,
		'discPoids' => $discPoids,
		'discBalle' => $discBalle,
		'discJavelot' => $discJavelot,
	));
});

// GET request on /diplomes-export/:annee, simply show the view template statistiques.twig
$app->get('/diplomes-export/:annee', function ($annee) use ($app, $model) {

	$anneeMin = (string) $annee - 15;
	$anneeMax = (string) $annee - 10;

	$athletes = $model->getAthletesDiplomes($annee, $anneeMin, $anneeMax);
	$disc60m = $model->get60mDipl($annee);
	$disc80m = $model->get80mDipl($annee);
	$disc60mh = $model->get60mhDipl($annee);
	$disc80mh = $model->get80mhDipl($annee);
	$disc100mh = $model->get100mhDipl($annee);
	$disc1000m = $model->get1000mDipl($annee);
	$discHauteur = $model->getHauteurDipl($annee);
	$discLongueur = $model->getLongueurDipl($annee);
	$discPoids = $model->getPoidsDipl($annee);
	$discBalle = $model->getBalleDipl($annee);
	$discJavelot = $model->getJavelotDipl($annee);

    $app->render('diplomes-export.twig', array(
		'athletes' => $athletes,
		'annee' => $annee,
		'disc60m' => $disc60m,
		'disc80m' => $disc80m,
		'disc60mh' => $disc60mh,
		'disc80mh' => $disc80mh,
		'disc100mh' => $disc100mh,
		'disc1000m' => $disc1000m,
		'discHauteur' => $discHauteur,
		'discLongueur' => $discLongueur,
		'discPoids' => $discPoids,
		'discBalle' => $discBalle,
		'discJavelot' => $discJavelot,
	));
});

// GET request on categories/:categorie/:annee, simply show the view template categories.twig
$app->get('/categories(/:annee(/:categorie))', function ($annee = NULL, $categorie = NULL) use ($app, $model) {

	if (isset($annee) && isset($categorie)) {

		$athletes = [];
		$indoor = $app->request->get('indoor');
		$minimas = $app->request->get('minimas');

		// Si en indoor
		if ($indoor == "1") {
			$dateMax = (string) $annee."-03-31";
			$dateMin = (string) $annee."-01-01";
		}
		// Si en outdoor
		if ($indoor == "0") {
			$dateMax = (string) $annee."-12-31";
			$dateMin = (string) $annee."-04-01";
		}
		// Si que l'année en cours (pas défini)
		if (!isset($indoor)) {
			$dateMax = (string) $annee."-12-31";
			$dateMin = (string) $annee."-01-01";
		}
		// Si minimas (2 dernières années) des résultats
		if ($minimas == "1") {
			$anneeMinimas = $annee-1;
			$dateMin = (string) $anneeMinimas."-01-01";
		}

		if ($categorie == "u23") {
			$anneeAthlMax = (string) $annee - 20;
			$anneeAthlMin =  (string) $annee - 22;
		}
		if ($categorie == "u20") {
			$anneeAthlMax = (string) $annee - 18;
			$anneeAthlMin =  (string) $annee - 19;
		}
		if ($categorie == "u18") {
			$anneeAthlMax = (string) $annee - 16;
			$anneeAthlMin =  (string) $annee - 17;
		}
		if ($categorie == "u16") {
			$anneeAthlMax = (string) $annee - 14;
			$anneeAthlMin =  (string) $annee - 15;
		}
		if ($categorie == "u14") {
			$anneeAthlMax = (string) $annee - 12;
			$anneeAthlMin =  (string) $annee - 13;
		}
		if ($categorie == "u12") {
			$anneeAthlMax = (string) $annee - 10;
			$anneeAthlMin =  (string) $annee - 11;
		}
		if ($categorie == "u10") {
			$anneeAthlMax = (string) $annee - 8;
			$anneeAthlMin =  (string) $annee - 9;
		}

		if ($categorie == "all") {
			$anneeAthlMax = NULL;
			$anneeAthlMin = NULL;
		}

		$athletes = $model->getAthletesCategories($dateMin, $dateMax, $anneeAthlMax, $anneeAthlMin);
		$disciplines = $model->getDisciplinesCategories($dateMin, $dateMax, $anneeAthlMax, $anneeAthlMin);
		//$resultats = $model->getResultatsCategories($dateMin, $dateMax, $anneeAthlMax, $anneeAthlMin);

		foreach ($athletes as $keyAth => $ath) {
			foreach ($disciplines as $keyDisc => $disc) {
				$nomDisc = $disc->id_d;
				$idAth = $ath->id_a;
				$idDisc = $disc->id_d;
				$triDisc = $disc->tri_d;
				$resultatDisc = $model->getResultatsCategoriesId($dateMin, $dateMax, $anneeAthlMax, $anneeAthlMin, $idAth, $idDisc, $triDisc);
				if (isset($resultatDisc->performance)) {
					$perfDisc = $resultatDisc->performance;
				} else {
					$perfDisc = "";
				}
				$athletes[$keyAth]->$nomDisc = $perfDisc;
			}
		}
		/* echo '<pre>';
		print_r ($athletes);
		echo '</pre>';*/

		$app->render('categorie.twig', array(
			'athletes' => $athletes,
			'disciplines' => $disciplines,
			'annee' => $annee,
			'categorie' => $categorie,
			'anneeAthlMax' => $anneeAthlMax,
			'anneeAthlMin' => $anneeAthlMin,
			'dateMax' => $dateMax,
			'dateMin' => $dateMin,

		));

	} // end /categories/:annee/:categorie
	else {
		$app->render('categories.twig', array(
			'annee' => date("Y"),
			'categorie' => "all",
		));
	} // end /categories
});

/******************************************* RUN THE APP *******************************************************/

$app->run();
