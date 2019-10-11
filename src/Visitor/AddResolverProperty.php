<?php

/**
 * Spiral Framework.
 *
 * @license MIT
 * @author  Valentin V (Vvval)
 */
declare(strict_types=1);

namespace Cycle\ORM\Promise\Visitor;

use Cycle\ORM\Promise\PHPDoc;
use Cycle\ORM\Promise\Utils;
use PhpParser\Builder\Property;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * Add resolver property
 */
final class AddResolverProperty extends NodeVisitorAbstract
{
    /** @var string */
    private $property;

    /** @var string */
    private $type;

    /** @var string */
    private $class;

    /**
     * @param string $property
     * @param string $type
     * @param string $class
     */
    public function __construct(string $property, string $type, string $class)
    {
        $this->property = $property;
        $this->type = $type;
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Class_) {
            $node->stmts = Utils::injectValues($node->stmts, $this->definePlacementID($node), [$this->buildProperty()]);
        }

        return null;
    }

    /**
     * @param Node\Stmt\Class_ $node
     * @return int
     */
    private function definePlacementID(Node\Stmt\Class_ $node): int
    {
        foreach ($node->stmts as $index => $child) {
            if ($child instanceof Node\Stmt\ClassMethod) {
                return $index;
            }
        }

        return 0;
    }

    /**
     * @return Node\Stmt\Property
     */
    private function buildProperty(): Node\Stmt\Property
    {
        $property = new Property($this->property);
        $property->makePrivate();
        $property->setDocComment(PHPDoc::writeProperty("{$this->type}|{$this->class}"));

        return $property->getNode();
    }
}
