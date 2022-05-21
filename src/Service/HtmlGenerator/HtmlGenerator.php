<?php
namespace App\Service\HtmlGenerator;

use App\Model\Entity\Order;
use App\Service\HtmlGenerator\Interface\HtmlGeneratorInterface;
use \Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Generate entity objects to html.
 *
 * Class HtmlGenerator
 *
 * @package App\Service\HtmlGenerator
 */
class HtmlGenerator implements HtmlGeneratorInterface
{
    /**
     * Order entity.
     *
     * @var Order|null
     */
    private ?Order $order;

    /**
     * Twig template.
     *
     * @var Environment
     */
    private $twig;

    /**
     * Template path.
     *
     * @var string
     */
    private const TEMPLATE_PATH = __DIR__ . '/Template/';

    /**
     * HtmlGenerator constructor.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(static::TEMPLATE_PATH);
        $this->twig = new Environment($loader);
    }

    /**
     * Get order entity.
     *
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * Set order entity.
     *
     * @param Order $order
     *
     * @return $this
     */
    public function setOrder(Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Parse order to html.
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws \Exception
     */
    public function parseOrderToHtml(): string
    {
        $order = $this->getOrder();

        if (empty($order)) {
            throw new \Exception("Empty order");
        }

        $info = json_decode($order->getInfo());

        return $this->twig->render('order.html.twig', [
            'order' =>$order,
            'info' => $info
        ]);
    }
}
