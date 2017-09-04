<?php

namespace DoubleLink;
use Node;


class DoubleLink
{
    const walk_backwards = "BACKWARDS" ;
    const walk_forward = "FORWARD";

    public $nodeList;
    public $first;
    public $last;

    /**
     * DoubleLink constructor.
     */
    public function __construct()
    {
        $this->nodeList = array();
        $this->first = null;
        $this->last = null;
    }

    /**
     * @return array of Node\Node
     */
    public function getNodeList()
    {
        return $this->nodeList;
    }

    /**
     * @param Node $node
     */
    public function addToNodeList(Node\Node $node)
    {
        $this->nodeList[] = $node;
    }

    /**
     * @return Node\Node
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @param Node\Node $first
     */
    public function setFirst($first)
    {
        $this->first = $first;
    }

    /**
     * @return Node\Node $last
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * @param Node\Node $last
     */
    public function setLast($last)
    {
        $this->last = $last;
    }

    /**
     * @return boolean
     */
    private function listIssEmpty(){
        return (boolean) ($this->getFirst()==null) ;
    }

    /**
     * @param Node $node
     * @return boolean
     */
    private function isLast(Node\Node $node){
        return (boolean) ($this->getLast()==$node) ;
    }

    /**
     * @param Node $node
     * @return boolean
     */
    private function isFirst(Node\Node $node){
        return (boolean) ($this->getFirst()==$node) ;

    }


    /**
     * @param Node $node
     * @throws
     */
    public function addNode(Node\Node $node){

        if (!($node instanceof Node)){
         //  throw Exeption;
        }


        if ($this->listIssEmpty()){
            $this->setFirst($node);
            $this->setLast($node);
            $this->addToNodeList($node);
        }
        else {
            $previous = $this->getLast();
            $previous->setNext($node);
            $node->setPrevious($previous);
            $this->setLast($node);
            $this->addToNodeList($node);
        }

    }


    /**
     * if mode is backwards, walks the array from the last to the first.
     * Default is walking from the first to the last
     * @param string $mode
     * @return array
     */
    public function walkDoubleLink($mode=SELF::walk_forward){

        $backwards = (boolean)($mode==SELF::walk_backwards);
        $messages = array();
        $walker = ($backwards)?$this->getLast():$this->getFirst() ;
        while ($walker!=null){
            $messages[] = $walker->getMessage();
            $walker = ($backwards)?$walker->getPrevious():$walker->getNext();
        }

        return $messages;

    }


    /**
     * @param $message
     * @return Node
     */
    public function searchNode($message){
        $found = false ;
        $searcher = $this->getFirst() ;
        while ($searcher!=null && !$found){
            if ($searcher->getMessage() == $message){
                $found = true ;
            }
            else $searcher = $searcher->getNext();
        }
        return $searcher ;
    }

    /**
     * @param $message
     * @return bool
     */
    public function deleteNode($message){
        
        $node = $this->searchNode($message);
        if ($node!=null && !$this->isFirst($node)){
            $nodePrevious = $node->getPrevious();
            $nodeNext  = $node->getNext();
            $nodePrevious->setNext($nodeNext);
            if (!$this->isLast($node)) {
                $nodeNext->setPrevious($nodePrevious);
            }
            unset($node);
            return true;
        }
        return false;
    }
  


}