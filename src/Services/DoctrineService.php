<?php


namespace App\Services;


use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\EntityGenerator;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use Doctrine\ORM\Tools\Setup;

/**
 * Doctrine generator service.
 * Class DoctrineService
 * @package App\Services
 */
class DoctrineService
{
    public function reverseEngineer(array $myConfig): void
    {
        // Create a simple "default" Doctrine ORM configuration for Annotations
        $isDevMode = true;
        $cache = new ArrayCache();
        $config = Setup::createAnnotationMetadataConfiguration(array($myConfig['entityLocation']), $isDevMode);
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl($cache);

        // obtaining the entity manager
        $entityManager = EntityManager::create($myConfig['dbParam'], $config);
        $driver = new DatabaseDriver($entityManager->getConnection()->getSchemaManager());
        $driver->setNamespace($myConfig['namespace']);
        $entityManager->getConfiguration()->setMetadataDriverImpl($driver);

        $platform = $entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
        $platform->registerDoctrineTypeMapping('set', 'string');
        $platform->registerDoctrineTypeMapping('blob', 'string');
        $platform->registerDoctrineTypeMapping('bit', 'boolean');

        $cmf = new DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($entityManager);
        $metadata = $cmf->getAllMetadata();

        $cme = new ClassMetadataExporter();
        $exporter = $cme->getExporter('yml', $myConfig['ymlLocation']);
        $exporter->setMetadata($metadata);
        $exporter->export();

        $generator = new EntityGenerator();
        $generator->setGenerateAnnotations(true);
        $generator->setGenerateStubMethods(true);
        $generator->setRegenerateEntityIfExists(true);
        $generator->setUpdateEntityIfExists(true);
        $generator->setBackupExisting(false);
        $generator->generate($metadata, $myConfig['entityLocation']);
    }
}
