<?php

namespace leboncoinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="leboncoinBundle\Repository\ImageRepository")
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @Assert\File(maxSize="6000000")
    */
    private $file;


    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;
    
    /**
    * @ORM\ManyToOne(targetEntity="Annonce", inversedBy="images", cascade={"persist"})
    * @ORM\JoinColumn(name="id_Annonce", referencedColumnName="id",onDelete="SET NULL")
    */
    protected $annonce;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Image
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Set path
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set annonce
     *
     * @param \leboncoinBundle\Entity\Annonce $annonce
     *
     * @return Image
     */
    public function setAnnonce(\leboncoinBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \leboncoinBundle\Entity\Annonce
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }
    
    public function getAbsolutePath()
{
    return null === $this->path
        ? null
        : $this->getUploadRootDir().'/'.$this->path;
}

public function getWebPath()
{
    return null === $this->path
        ? null
        : $this->getUploadDir().'/'.$this->path;
}

protected function getUploadRootDir()
{
    // the absolute directory path where uploaded
    // documents should be saved
    return __DIR__.'/../../../web/'.$this->getUploadDir();
}

protected function getUploadDir()
{
    // get rid of the __DIR__ so it doesn't screw up
    // when displaying uploaded doc/image in the view.
    return 'bundles/leboncoin/image';
}

/**
 * @ORM\PrePersist()
 * @ORM\PreUpdate()
 */
public function preUpload()
{
    if (null !== $this->file) {
        // do whatever you want to generate a unique name
        $filename = sha1(uniqid(mt_rand(), true));
        $this->path = $filename.'.'.$this->file->guessExtension();
    }
}

/**
 * @ORM\PostPersist()
 * @ORM\PostUpdate()
 */
public function upload()
{
    /*if (null === $this->file) {
        return;
    }*/
    
    
     
    // if there is an error when moving the file, an exception will
    // be automatically thrown by move(). This will properly prevent
    // the entity from being persisted to the database on error
    $this->file->move($this->getUploadRootDir(), $this->path);

    unset($this->file);
}

/**
 * @ORM\PostRemove()
 */
public function removeUpload()
{
    if ($file = $this->getAbsolutePath()) {
        unlink($file);
    }
}
}
