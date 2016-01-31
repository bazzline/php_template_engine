<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-01-30
 */
namespace Net\Bazzline\Component\Template;

use Composer\Semver\Constraint\Constraint;

class TryToInstallZendExpressiveTemplate
{
    /**
     * @param \Composer\Installer\InstallerEvent $event
     * @see
     *  https://getcomposer.org/doc/articles/scripts.md#defining-scripts
     *  https://getcomposer.org/apidoc/master/Composer/Installer/InstallerEvent.html
     *  http://jakoch.de/2015/10/23/how-to-create-a-composer-plugin/
     *  https://github.com/composer/composer/issues/3430
     */
    public static function execute($event)
    {
        if ($event->isDevMode()) {
            $minimumVersionForZendExpressiveTemplate    = '5.5.0';
            $itFitsAtLeastTheMinimumVersionRequirement  = (version_compare(PHP_VERSION, $minimumVersionForZendExpressiveTemplate) >= 0);

            if ($itFitsAtLeastTheMinimumVersionRequirement) {
                $constraint = new Constraint('>=', '1.0.*');
                $request    = $event->getRequest();
                /** @var \Composer\DependencyResolver\Request $request */
                $request->install('zendframework/zend-expressive-template', $constraint);
                $request->update('zendframework/zend-expressive-template', $constraint);
            } else {
                /** @var \Composer\IO\IOInterface $io */
                $io = $event->getIO();
                $io->write('can not install optional dependency zend-expressive-template in development mode');
                $io->write('it needs at least php version "' . $minimumVersionForZendExpressiveTemplate . '"');
            }
        }
    }
}