<?php

namespace Awaresoft\FaqBundle\Entity;

use Awaresoft\Sonata\PageBundle\Entity\Site;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Awaresoft\TreeBundle\Entity\AbstractTreeNode;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 * @Gedmo\Tree(type="nested")
 *
 * @author Bartosz Malec <b.malec@awaresoft.pl>
 */
class Faq extends AbstractTreeNode
{
    const TREE_MAIN_COLUMN = 'name';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="tree_left")
     *
     * @Gedmo\TreeLeft
     *
     * @var int
     */
    protected $left;

    /**
     * @ORM\Column(type="integer", name="tree_right")
     *
     * @Gedmo\TreeRight
     *
     * @var int
     */
    protected $right;

    /**
     * @ORM\ManyToOne(targetEntity="Faq", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Gedmo\TreeParent
     *
     * @var Faq
     */
    protected $parent;

    /**
     * @ORM\Column(type="integer", nullable=true, name="tree_root")
     *
     * @Gedmo\TreeRoot
     *
     * @var Faq
     */
    protected $root;

    /**
     * @ORM\Column(name="tree_level", type="integer")
     *
     * @Gedmo\TreeLevel
     *
     * @var int
     */
    protected $level;

    /**
     * @ORM\OneToMany(targetEntity="Faq", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     *
     * @var Faq[]
     */
    protected $children;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Awaresoft\Sonata\PageBundle\Entity\Site")
     *
     * @var Site
     */
    protected $site;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Gedmo\Slug(fields={"name"})
     *
     * @var string
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $rawContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $contentFormatter;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var bool
     */
    protected $enabled;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $voteUp;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $voteDown;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $visits;

    /**
     * Faq constructor.
     */
    public function __construct()
    {
        $this->voteUp = 0;
        $this->voteDown = 0;
        $this->visits = 0;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param $left
     *
     * @return Faq
     */
    public function setLeft($left)
    {
        $this->left = $left;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param mixed $right
     *
     * @return Faq
     */
    public function setRight($right)
    {
        $this->right = $right;

        return $this;
    }

    /**
     * @return Faq
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Faq $parent
     *
     * @return Faq
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param mixed $root
     *
     * @return Faq
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     *
     * @return Faq
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     *
     * @return Faq
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Faq
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     *
     * @return Faq
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Faq
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param string $rawContent
     *
     * @return Faq
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * @return string
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * @param string $contentFormatter
     *
     * @return Faq
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     *
     * @return Faq
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return int
     */
    public function getVoteUp()
    {
        return $this->voteUp;
    }

    /**
     * @param int $voteUp
     *
     * @return Faq
     */
    public function setVoteUp($voteUp)
    {
        $this->voteUp = $voteUp;

        return $this;
    }

    /**
     * @return int
     */
    public function getVoteDown()
    {
        return $this->voteDown;
    }

    /**
     * @param int $voteDown
     *
     * @return Faq
     */
    public function setVoteDown($voteDown)
    {
        $this->voteDown = $voteDown;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Faq
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return Faq
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * @param int $visits
     *
     * @return Faq
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;

        return $this;
    }

    /**
     * @return Faq
     */
    public function addVisit()
    {
        $this->visits++;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitleFieldName()
    {
        return self::TREE_MAIN_COLUMN;
    }

    /**
     * Return votes difference
     *
     * @return int
     */
    public function getVotes()
    {
        return $this->voteUp - $this->voteDown;
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param Site $site
     *
     * @return $this
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }
}