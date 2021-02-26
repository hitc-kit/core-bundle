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
        $menuNode = $this->manager->getRepository(Node::class)->findOneBy(['alias' => $name]);

        if ($menuNode) {
            $loader = new NodeLoader($this->factory);
            $root = $loader->load($menuNode);
            $class = (isset($options['rootClass'])) ? trim($options['rootClass']) : false;

            if ($class) {
                $root->setChildrenAttribute('class', $class);
            }

            return $root;
        } else {
            throw new InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
        }
    }

    /**
     * @inheritDoc
     */
    public function has(string $name, array $options = []): bool
    {
        return (bool)$this->manager->getRepository(Node::class)->findOneBy(['alias' => $name]);
    }
}
