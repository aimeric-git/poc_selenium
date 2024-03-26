<?php 

namespace App\Tests\Functional;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testNewTaskForm()
    {
        $host = 'http://localhost:4444/wd/hub'; // Adresse de votre serveur Selenium WebDriver
        $browser = DesiredCapabilities::firefox(); // Sélectionnez le navigateur que vous souhaitez utiliser

        $driver = RemoteWebDriver::create($host, $browser);

        // Naviguer vers la page de création de tâche
        $driver->get('http://localhost:8000/task/new');

        // Remplir le formulaire
        $driver->findElement(WebDriverBy::id('new_task_form_title'))->sendKeys('Nouvelle tâche');
        $driver->findElement(WebDriverBy::id('new_task_form_description'))->sendKeys('Description de la nouvelle tâche');

        // Soumettre le formulaire
        $driver->findElement(WebDriverBy::id('new_task_form_submit'))->click();

        // Vérifier si la redirection a eu lieu
        $this->assertEquals('http://localhost:8000/task', $driver->getCurrentURL());

        // Fermer le navigateur
        $driver->quit();
    }
}