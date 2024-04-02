<?php 

namespace App\Tests\Functional;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
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
        $driver->findElement(WebDriverBy::id('new_task_form_title'))->sendKeys('New task 11');
        $driver->findElement(WebDriverBy::id('new_task_form_description'))->sendKeys('New Description 11');

        // Soumettre le formulaire
        $driver->findElement(WebDriverBy::id('btn_form_new'))->click();

        // Vérifier si la redirection a eu lieu
        $this->assertEquals('http://localhost:8000/', $driver->getCurrentURL());

        // Fermer le navigateur
        $driver->quit();
    }

    public function testEditTaskForm()
    {
        $host = 'http://localhost:4444/wd/hub'; 
        $browser = DesiredCapabilities::firefox(); 

        $driver = RemoteWebDriver::create($host, $browser);

        
        $id = 4; 
        $driver->get('http://localhost:8000/task/edit/' . $id);

        $driver->findElement(WebDriverBy::id('new_task_form_title'))->clear();
        $driver->findElement(WebDriverBy::id('new_task_form_title'))->sendKeys('Titre modifié 3');
        $driver->findElement(WebDriverBy::id('new_task_form_description'))->clear();
        $driver->findElement(WebDriverBy::id('new_task_form_description'))->sendKeys('Description modifiée 3');

        $driver->findElement(WebDriverBy::id('btn_form_edit'))->click();

        $this->assertEquals('http://localhost:8000/', $driver->getCurrentURL());

        $driver->quit();
    }

    public function testDeleteTask()
    {
        $host = 'http://localhost:4444/wd/hub';
        $browser = DesiredCapabilities::firefox();
        
        $driver = RemoteWebDriver::create($host, $browser);
        
        $driver->get('http://localhost:8000/');
        
        $lastTask = $driver->findElement(WebDriverBy::cssSelector('.table tbody tr:last-child'));
        $deleteButton = $lastTask->findElement(WebDriverBy::id('btn_suppr_task'));
        $deleteButton->click();
        
        $this->assertEquals('http://localhost:8000/', $driver->getCurrentURL());
        $driver->quit();
    }

    public function testShowTask()
    {
        $host = 'http://localhost:4444/wd/hub';
        $browser = DesiredCapabilities::firefox();
        
        $driver = RemoteWebDriver::create($host, $browser);
        
        $driver->get('http://localhost:8000/');
        
        $lastTask = $driver->findElement(WebDriverBy::cssSelector('.table tbody tr:last-child'));
        $showButton = $lastTask->findElement(WebDriverBy::id('btn_show_task'));  
        $showButton->click();

        // $this->assertEquals('http://localhost:8000/', $driver->getCurrentURL());
        $this->assertNotEquals('http://localhost:8000/', $driver->getCurrentURL());
        $driver->quit();
    }
}