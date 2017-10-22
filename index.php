<?php

// In case you need it, uncoment this two lines to dubug code
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

// ========== PATHS ==========

define('ROOT_PATH', posix_getcwd());
define('APP_PATH',  ROOT_PATH.'/app');
define('VAR_PATH',  ROOT_PATH.'/var');
define('WWW_PATH',  ROOT_PATH.'');

// ========== PHP (static) ==========

// errors

// https://github.com/filp/whoops
// https://github.com/Seldaek/monolog
// https://github.com/kint-php/kint
// https://github.com/maximebf/php-debugbar
// 
error_reporting(-1);
ini_set('error_log', VAR_PATH.'/log/php-'.date('Y-m').'.log');

// charset
ini_set('default_charset', 'UTF-8');

// ========== COMPOSER ==========

require ROOT_PATH.'/vendor/autoload.php';

// ========== CONFIGURATION ==========

$config_env = require APP_PATH . '/config/env.php';
$config = require APP_PATH . '/config.php';
$config_db = require APP_PATH . '/config/db.php';

// ===== ENVIRONMENT MODE ========

$config_mode = $config_env['mode'];

// ========== PHP (from configuration) ==========

// time zone
date_default_timezone_set($config['PHP']['default_timezone']);

// errors
ini_set('display_errors',         $config['PHP']['display_errors']);
ini_set('display_startup_errors', $config['PHP']['display_startup_errors']);
ini_set('log_errors',             $config['PHP']['log_errors']);

unset($config['PHP']);

// ========== i18n ==========

// https://stackoverflow.com/questions/30570929/detect-browser-language-in-php-and-set-locale-accordingly
// https://github.com/KuenzelIT/auto-lang
// https://github.com/Menencia/locale-detector
// https://github.com/sinergi/php-browser-detector
// https://github.com/fisharebest/localization
// https://github.com/basz/SlmLocale
// https://github.com/oscarotero/Gettext
// http://www.lostinsoftware.com/2015/02/php-internationalization-with-gettext/

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
 
//$application = new Application();
//$application->run();

// Symfony namespaces
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

// language
if ($config['App']['language_code'] == "") {
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
} else {
	$lang = $config['App']['language_code'];
}

// First param is the "default language" to use.
$translator = new Translator($lang, new MessageSelector());
// Set a fallback language incase you don't have a translation in the default language
$translator->setFallbackLocales(['en_US']);
// Add a loader that will get the php files we are going to store our translations in
$translator->addLoader('php', new PhpFileLoader());
// Add language files here
$translator->addResource('php', APP_PATH . '/lang/fr.php', 'fr');
$translator->addResource('php', APP_PATH . '/lang/en.php', 'en');


// ========== SLIM ==========

// Create Slim app @see http://
$app = new \Slim\Slim(array(
	'settings' => $config,
	'mode' => $config_mode,
));

// and define the engine used for the view @see http://twig.sensiolabs.org
$app->view = new \Slim\Views\Twig(['cache' => false]);
$app->view->setTemplatesDirectory(APP_PATH. "/view");

$app->view->parserExtensions = [
	new \Slim\Views\TwigExtension(),
	new TranslationExtension($translator),
	new \Twig_Extension_Debug()
];

	
// Pass config variable from config.yml (only 'App' and'Security) to all the views.
// Use {{ config.xxx }} Twig syntax
$mergedConfig = array_merge($config['App'], $config['Security']);
$app->view->set("config", $mergedConfig);

// Pass url variables from config/env.php to all the views.
// Use {{ siteUrl }} and {{ currentUrl }} Twig syntax
$app->view->set("siteUrl", $config_env[$app->mode]['siteUrl']);
$app->view->set("currentUrl", $config_env[$app->mode]['siteUrl'] . $app->request->getResourceUri());

// ========== SLIM ==========

// pre-application hook, performs stuff before real action happens @see http://docs.slimframework.com/#Hooks
$app->hook('slim.before', function () use ($app) {
	
	// SASS-to-CSS compiler @see https://github.com/panique/php-sass
	/*
	if ($config_mode) == 'development') {
		//SassCompiler::run("scss/", "css/");
		}
	*/

	// CSS minifier @see https://github.com/matthiasmullie/minify
	$minifier = new MatthiasMullie\Minify\CSS('assets/css/style.css');
	$minifier->minify('assets/css/style.min.css');

	// JS minifier @see https://github.com/matthiasmullie/minify
	// DON'T overwrite your real .js files, always save into a different file
	//$minifier = new MatthiasMullie\Minify\JS('js/application.js');
	//$minifier->minify('js/application.min.js');
});

// ========== MODEL ==========

// Initialize the model, pass the database configs. $model can now perform all methods from Mini\Model\Model.php
$model = new Mini\Model\Model($config_db[$app->mode]);

// ========== THE ROUTES / CONTROLLERS ==========

// GET request on homepage, simply show the view template index.twig
$app->get('/', function () use ($app, $model) {

	$athletes = $model->getAllAthletes();

	$app->render('index.twig', array(
		'athletes' => $athletes
		));
	});

// All requests on /athletes and behind (/athletes/search etc) are grouped here. Note that $model is passed (as some routes
// in /athletes... use the model)
$app->group('/athletes', function () use ($app, $model) {

    // GET request on /athletes. Perform actions getAllAthletes() and pass the result to the view.
    $app->get('/', function () use ($app, $model) {
        $athletes = $model->getAllAthletes();

        $app->render('athletes.twig', array(
            'athletes' => $athletes
        ));
	});

	// GET request on /songs/:athlete_id. If athlete id exists show the athlete page.
    $app->get('/:athlete_id', function ($athlete_id) use ($app, $model) {

        $discipline_id = $app->request->params('disc');
		if (!$discipline_id) {$discipline_id = 'all';}

		$athlete = $model->getAthlete($athlete_id);
		$results = $model->getResults($athlete_id);
		//$years = $model->getAthleteYears($athlete_id);
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

// GET request on resultat/:resultat_id, simply show the view template resultat.twig
$app->get('/resultat/:resultat_id', function ($resultat_id) use ($app, $model) {

    $resultat = $model->getResultat($resultat_id);

	$app->render('resultat.twig', array(
			'resultat_id' => $resultat_id,
			'resultat' => $resultat
	));
});

// GET request on /competitions/:competition_id, simply show the view template competitions.twig
$app->get('/competitions/:competition_id', function ($competition_id) use ($app, $model) {

    $resultats = $model->getResultatsByCompetition($competition_id);

	$app->render('competition.twig', array(
			'competition_id' => $competition_id,
			'resultats' => $resultats
	));
});

// GET request on /reports, simply show the view template reports.twig
$app->get('/reports', function () use ($app) {
    $app->render('reports.twig');
});

// GET request on /about, simply show the view template about.twig
$app->get('/about', function () use ($app) {
    $app->render('about.twig');
});

// GET request on /statistiques, redirect to id 42 : statistiques/42 (100m in the database)
$app->get('/statistiques', function () use ($app) {
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

// GET request on /diplomes/:annee, simply show the view template diplomes.twig
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

// GET request on /diplomes-export/:annee, simply show the view template diplomes-export.twig
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
	}
}); // end /categories

/******************************************* RUN THE APP *******************************************************/

$app->run();
