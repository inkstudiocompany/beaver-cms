Beaver CMS
Notas de instalación.

**Core Configration**

*Parameters:*

* Page Layouts: with Classes for Layouts (There are will be change for twigs list)

    parameters:
        page.layouts:
            - Beaver\CoreBundle\Model\Page\Layout\DefaultLayout
            
* contents:
    - { type: dummy, name: 'Dummy content', manager: \Beaver\ContentBundle\Contents\Dummy\DummyManager }   
    

* Layouts:

Son los templates de maquetado, en este caso Twig files, que definen la estructura.

