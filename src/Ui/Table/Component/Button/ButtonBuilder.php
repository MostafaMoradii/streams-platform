<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonBuilder
{

    /**
     * The button reader.
     *
     * @var ButtonInput
     */
    protected $input;

    /**
     * The button parser.
     *
     * @var ButtonParser
     */
    protected $parser;

    /**
     * The button factory.
     *
     * @var ButtonFactory
     */
    protected $factory;

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new ButtonBuilder instance.
     *
     * @param ButtonInput   $input
     * @param ButtonParser  $parser
     * @param ButtonFactory $factory
     * @param Evaluator     $evaluator
     */
    public function __construct(ButtonInput $input, ButtonParser $parser, ButtonFactory $factory, Evaluator $evaluator)
    {
        $this->input     = $input;
        $this->parser    = $parser;
        $this->factory   = $factory;
        $this->evaluator = $evaluator;
    }

    /**
     * Build the buttons.
     *
     * @param TableBuilder $builder
     * @param              $entry
     * @return ButtonCollection
     */
    public function build(TableBuilder $builder, $entry)
    {
        $table = $builder->getTable();

        $buttons = new ButtonCollection();

        $this->input->read($builder, $entry);

        foreach ($builder->getButtons() as $button) {

            $button = $this->evaluator->evaluate($button, compact('entry', 'table'));
            $button = $this->parser->parser($button, $entry);

            $button = $this->factory->make($button);

            $button->setSize('sm');

            $buttons->push($button);
        }

        return $buttons;
    }
}
