<?php


namespace HitcKit\CoreBundle\Provider;

use HitcKit\CoreBundle\Entity\Node;
use InvalidArgumentException;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Loader\NodeLoader;
use Knp\Menu\Provider\MenuProviderInterface;
use Doctrine\ORM\EntityManagerInterface;

class CoreMenuProvider implements MenuProviderInterface
{
    protected $factory;
    protected $manager;
    private $cache = [];

    public function __construct(FactoryInterface $factory, EntityManagerInterface $manager)
    {
        $this->factory = $factory;
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function get(string $name, array $options = []): ItemInterface
    {
        if (!isset($this->cache[$name])) {
            $repository = $this->manager->getRepository(Node::class);
            $node = $repository->findOneBy(['alias' => $name]) ?: $repository->find((int)$name);

            if ($node) {
                $loader = new NodeLoader($this->factory);
                $menu = $loader->load($node);
                $this->cache[$name] = $menu;
            } else {
                throw new InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
            }
        }

        if (isset($options['rootClass'])) {
            $this->cache[$name]->setChildrenAttribute('class', trim($options['rootClass']));
        }

        return $this->cache[$name];
    }

    /**
     * @inheritDoc
     */
    public function has(string $name, array $options = []): bool
    {
        return (bool)$this->manager->getRepository(Node::class)->findOneBy(['alias' => $name]);
    }
}
