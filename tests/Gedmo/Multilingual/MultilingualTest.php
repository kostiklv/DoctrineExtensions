<?php

namespace Gedmo\Multilingual;

use Doctrine\Common\EventManager;
use Tool\BaseTestCaseORM;
use Multilingual\Fixture\Person;

/**
 * These are tests for translatable behavior
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 * @package Gedmo.Translatable
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class MultilingualTest extends BaseTestCaseORM
{
    const PERSON = 'Multilingual\\Fixture\\Person';

    protected function setUp()
    {
        parent::setUp();

        $evm = new EventManager;

        $evm->addEventSubscriber(new MultilingualListener());

        $this->getMockSqliteEntityManager($evm);
    }

    public function testMultilingual()
    {
        $person = new Person();
        $person->setName('Jen');
        $person->setDescription('description');

        $person->setTranslation('name', 'ru', 'Vasya_RU');

        $this->em->persist($person);
        $this->em->flush();

        $id = $person->getId();

        $loadedPerson = $this->em->find(self::PERSON, $id);

        $this->assertSame('Jen', $loadedPerson->getName());
        $this->assertSame('description', $loadedPerson->getDescription());

        $this->assertSame('Vasya_RU', $loadedPerson->getTranslation('name', 'ru'));

    }

    /**
    * Get annotation mapping configuration
    *
    * @return Doctrine\ORM\Configuration
    */
    protected function getMockAnnotatedConfig()
    {
        $config = $this->getMock('Doctrine\ORM\Configuration');

        $config
            ->expects($this->once())
            ->method('getProxyDir')
            ->will($this->returnValue(__DIR__.'/../../temp'))
        ;

        $config
            ->expects($this->once())
            ->method('getProxyNamespace')
            ->will($this->returnValue('Proxy'))
        ;

        $config
            ->expects($this->once())
            ->method('getAutoGenerateProxyClasses')
            ->will($this->returnValue(true))
        ;

        $config
           ->expects($this->once())
           ->method('getClassMetadataFactoryName')
           ->will($this->returnValue('Gedmo\\Multilingual\\Mapping\\MultilingualMetadataFactory'))
        ;

        $mappingDriver = $this->getMetadataDriverImplementation();

        $config
            ->expects($this->any())
            ->method('getMetadataDriverImpl')
            ->will($this->returnValue($mappingDriver))
        ;

        $config
            ->expects($this->any())
            ->method('getDefaultRepositoryClassName')
            ->will($this->returnValue('Doctrine\\ORM\\EntityRepository'))
        ;

        return $config;
    }

    protected function getUsedEntityFixtures()
    {
        return array(
            self::PERSON,
        );
    }
}