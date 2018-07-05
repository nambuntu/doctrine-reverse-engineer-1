# Doctrine Reverse Engineer
Some programmers prefer defining models using code, some like the opposite. 
For us at Inlumina, we found it's pretty neat just to design the system using RDBMS modelling tools 
and create tools like this to generate code in return. 

This code generator will generate Doctrine models based on a database already designed for you.

# How to use
For the shake of simplicity, we put all the configuration in the command, please change it before using
```php
$myConfig = array(
            'dbParam' => array(
                'host' => '127.0.0.1',
                'driverClass' => Driver::class,
                'user' => 'root',
                'password' => '',
                'dbname' => 'test',
            ),
            'entityLocation' => 'src',
            'ymlLocation' => 'src/Entity/yml',
            'namespace' => 'Entity\\'
        );
```

# Run the command
```bash
composer install 
php bin/console db:reverse-engineer

```

# To learn more about Symfony and Doctrine
https://symfony.com/

https://www.doctrine-project.org/projects/orm.html

# Feedbacks?
Please send to nam@inlumina.work or leave comment here, we love to hear from you.
