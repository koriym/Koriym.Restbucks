<?php

namespace Koriym\Restbucks\Module;

use BEAR\Package\AppMeta;
use BEAR\Package\PackageModule;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FileCache;
use Doctrine\Common\Cache\FilesystemCache;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $appMeta = new AppMeta('Koriym\Restbucks');
        $this->bind(Cache::class)->annotatedWith('restbucks')->toConstructor(FilesystemCache::class, 'directory=tmp_dir')->in(Scope::SINGLETON);
        $this->bind()->annotatedWith('tmp_dir')->toInstance($appMeta->tmpDir);
        $this->install(new PackageModule($appMeta));
    }
}
