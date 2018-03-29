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



**Contents**

Beaver CMS provide a easy interface to create custom contents in quckly way.

For create a new content you need follow the next easy steps bellow:

* Define Doctrine Entity for your Content. This step is the base for the content, here it's defined our content and structure. We recomend define it at directory src/Entity.

* Define content Directory: We need make two more components, The Type, that define create/edition form and The Manager, resposible for content operation.

We recomend define this directory there, src/Contents/{NAME_CONTENT}

