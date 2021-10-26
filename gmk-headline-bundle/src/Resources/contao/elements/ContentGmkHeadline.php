<?php

namespace Makocupic\Gmk;

/**
 * Class ContentGmkHeadline
 * @package Makocupic\Gmk
 */
class ContentGmkHeadline extends \ContentElement
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_gmk_headline';


    /**
     * Return if the highlighter plugin is not loaded
     *
     * @return string
     */
    public function generate()
    {
        $arrHeadlineA = \StringUtil::deserialize($this->gmk_headline_one, true);
        $this->hlA = $arrHeadlineA['unit'];
        $this->headlineA = $arrHeadlineA['value'];

        $arrHeadlineA = \StringUtil::deserialize($this->gmk_headline_two, true);
        $this->hlB = $arrHeadlineA['unit'];
        $this->headlineB = $arrHeadlineA['value'];

        if (TL_MODE == 'BE')
        {

            $return = '';
            if ($this->headlineA != '')
            {
                $return .= '<' . $this->hlA . '>' . $this->headlineA . '</' . $this->hlA . '>';
            }
            if ($this->headlineB != '')
            {
                $return .= '<' . $this->hlB . '>' . $this->headlineB . '</' . $this->hlB . '>';
            }
            return $return;
        }

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        $arrHeadlineA = \StringUtil::deserialize($this->headline_one, true);
        $this->Template->hlA =$this->hlA;
        $this->Template->headlineA = $this->headlineA;

        $arrHeadlineA = \StringUtil::deserialize($this->headline_two, true);
        $this->Template->hlB =$this->hlB;
        $this->Template->headlineB = $this->headlineB;

    }
}