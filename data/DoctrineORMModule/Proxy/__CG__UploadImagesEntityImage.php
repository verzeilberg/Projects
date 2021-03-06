<?php

namespace DoctrineORMModule\Proxy\__CG__\UploadImages\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Image extends \UploadImages\Entity\Image implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'ImageId', '' . "\0" . 'UploadImages\\Entity\\Image' . "\0" . 'image', 'nameImage', 'alt', 'descriptionImage', 'sortOrder', '' . "\0" . 'UploadImages\\Entity\\Image' . "\0" . 'imageTypes'];
        }

        return ['__isInitialized__', 'ImageId', '' . "\0" . 'UploadImages\\Entity\\Image' . "\0" . 'image', 'nameImage', 'alt', 'descriptionImage', 'sortOrder', '' . "\0" . 'UploadImages\\Entity\\Image' . "\0" . 'imageTypes'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Image $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getImageTypes($imageTypeName = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImageTypes', [$imageTypeName]);

        return parent::getImageTypes($imageTypeName);
    }

    /**
     * {@inheritDoc}
     */
    public function setImageTypes($images)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImageTypes', [$images]);

        return parent::setImageTypes($images);
    }

    /**
     * {@inheritDoc}
     */
    public function addImageType(\UploadImages\Entity\ImageType $imageType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addImageType', [$imageType]);

        return parent::addImageType($imageType);
    }

    /**
     * {@inheritDoc}
     */
    public function removeImageType(\UploadImages\Entity\ImageType $imageType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeImageType', [$imageType]);

        return parent::removeImageType($imageType);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlt', []);

        return parent::getAlt();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlt($alt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlt', [$alt]);

        return parent::setAlt($alt);
    }

    /**
     * {@inheritDoc}
     */
    public function getBlogImageId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBlogImageId', []);

        return parent::getBlogImageId();
    }

    /**
     * {@inheritDoc}
     */
    public function setBlogImageId($blogImageId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBlogImageId', [$blogImageId]);

        return parent::setBlogImageId($blogImageId);
    }

    /**
     * {@inheritDoc}
     */
    public function getSortOrder()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSortOrder', []);

        return parent::getSortOrder();
    }

    /**
     * {@inheritDoc}
     */
    public function setSortOrder($sortOrder)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSortOrder', [$sortOrder]);

        return parent::setSortOrder($sortOrder);
    }

    /**
     * {@inheritDoc}
     */
    public function getNameImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNameImage', []);

        return parent::getNameImage();
    }

    /**
     * {@inheritDoc}
     */
    public function getDescriptionImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescriptionImage', []);

        return parent::getDescriptionImage();
    }

    /**
     * {@inheritDoc}
     */
    public function setNameImage($nameImage)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNameImage', [$nameImage]);

        return parent::setNameImage($nameImage);
    }

    /**
     * {@inheritDoc}
     */
    public function setDescriptionImage($descriptionImage)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescriptionImage', [$descriptionImage]);

        return parent::setDescriptionImage($descriptionImage);
    }

    /**
     * {@inheritDoc}
     */
    public function getImageId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImageId', []);

        return parent::getImageId();
    }

    /**
     * {@inheritDoc}
     */
    public function setImageId($ImageId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImageId', [$ImageId]);

        return parent::setImageId($ImageId);
    }

    /**
     * {@inheritDoc}
     */
    public function getImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImage', []);

        return parent::getImage();
    }

    /**
     * {@inheritDoc}
     */
    public function setImage($image)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImage', [$image]);

        return parent::setImage($image);
    }

}
