<?php
namespace ILoveAustin;

use GraphQL\Examples\Blog\Type\Enum\ContentFormatEnum;
use GraphQL\Type\Definition\FloatType;
use GraphQL\Type\Definition\IDType;
use GraphQL\Type\Definition\IntType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\StringType;
use GraphQL\Type\Definition\Type;
use ILoveAustin\Context\Context;
use ILoveAustin\Type\Enum\ImageSizeEnumType;
use ILoveAustin\Type\Field\HtmlField;
use ILoveAustin\Type\Input\ISODateType;
use ILoveAustin\Type\Input\MonthlyInputType;
use ILoveAustin\Type\Input\SavingsInputType;
use ILoveAustin\Type\Input\SnapshotInputType;
use ILoveAustin\Type\Scalar\EmailType;
use ILoveAustin\Type\Scalar\UrlType;
use ILoveAustin\Type\Type\AccountType;
use ILoveAustin\Type\Type\ImageType;
use ILoveAustin\Type\Type\MonthlyType;
use ILoveAustin\Type\Type\PeriodType;
use ILoveAustin\Type\Type\SavingsType;
use ILoveAustin\Type\Type\SnapshotType;

class Types
{
	/** @var ImageType */
    private static $image;
    /** @var QueryType */
    private static $query;
    /** @var MutationType */
    private static $mutation;
    /** @var AccountType */
    private static $account;
    /** @var ISODateType */
    private static $isoDate;
    /** @var MonthlyType */
    private static $monthly;
	/** @var MonthlyInputType */
	private static $monthlyInput;
	/** @var PeriodType */
	private static $period;
    /** @var SnapshotType */
    private static $snapshot;
    /** @var SnapshotInputType */
    private static $snapshotInput;
    /** @var SavingsType */
    private static $savings;
    /** @var SavingsInputType */
    private static $savingsInput;

    public static function account()
	{
		return self::$account ?: (self::$account = new AccountType());
	}

	public static function monthly()
	{
		return self::$monthly ?: (self::$monthly = new MonthlyType());
	}

	public static function monthlyInput()
	{
		return self::$monthlyInput ?: (self::$monthlyInput = new MonthlyInputType());
	}

	public static function savings()
	{
		return self::$savings ?: (self::$savings = new SavingsType());
	}

	public static function savingsInput()
	{
		return self::$savingsInput ?: (self::$savingsInput = new SavingsInputType());
	}

	public static function snapshot()
	{
		return self::$snapshot ?: (self::$snapshot = new SnapshotType());
	}

	public static function snapshotInput()
	{
		return self::$snapshotInput ?: (self::$snapshotInput = new SnapshotInputType());
	}

	public static function period()
	{
		return self::$period ?: (self::$period = new PeriodType());
	}

	public static function ISODate()
	{
    	return self::$isoDate ?: (self::$isoDate = new ISODateType());
	}

	/**
     * @return ImageType
     */
    public static function image()
    {
        return self::$image ?: (self::$image = new ImageType());
    }

	/**
	 * @param Context $context
	 * @return QueryType
	 */
    public static function query(Context $context)
    {
        return self::$query ?: (self::$query = new QueryType($context));
    }

	/**
	 * @param Context $context
	 * @return MutationType
	 */
    public static function mutation(Context $context)
	{
		return self::$mutation ?: (self::$mutation = new MutationType($context));
	}

    // Enum types
    private static $imageSizeEnum;
    private static $contentFormatEnum;

    /**
     * @return ImageSizeEnumType
     */
    public static function imageSizeEnum()
    {
        return self::$imageSizeEnum ?: (self::$imageSizeEnum = new ImageSizeEnumType());
    }

    /**
     * @return ContentFormatEnum
     */
    public static function contentFormatEnum()
    {
        return self::$contentFormatEnum ?: (self::$contentFormatEnum = new ContentFormatEnum());
    }

    // Custom Scalar types:
    private static $urlType;
    private static $emailType;

    public static function email()
    {
        return self::$emailType ?: (self::$emailType = EmailType::create());
    }

    /**
     * @return UrlType
     */
    public static function url()
    {
        return self::$urlType ?: (self::$urlType = new UrlType());
    }

    /**
     * @param $name
     * @param null $objectKey
     * @return array
     */
    public static function htmlField($name, $objectKey = null)
    {
        return HtmlField::build($name, $objectKey);
    }



    // Let's add internal types as well for consistent experience

    public static function boolean()
    {
        return Type::boolean();
    }

    /**
     * @return FloatType
     */
    public static function float()
    {
        return Type::float();
    }

    /**
     * @return IDType
     */
    public static function id()
    {
        return Type::id();
    }

    /**
     * @return IntType
     */
    public static function int()
    {
        return Type::int();
    }

    /**
     * @return StringType
     */
    public static function string()
    {
        return Type::string();
    }

    /**
     * @param Type $type
     * @return ListOfType
     */
    public static function listOf($type)
    {
        return new ListOfType($type);
    }

    /**
     * @param Type $type
     * @return NonNull
     */
    public static function nonNull($type)
    {
        return new NonNull($type);
    }
}
