<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $token
 * @property string $email
 * @property integer $token_create_time
 * @property integer $add_time
 * @property integer $last_login_time
 * @property string $last_login_ip
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     *
     */
    public $password2;
    public $role;

    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['token_create_time', 'add_time', 'last_login_time'], 'integer'],
            [['username', 'password', 'token', 'email'], 'string', 'max' => 255],
            [['last_login_ip'], 'string', 'max' => 15],
            ['auth_key','string','max'=>32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['token'], 'unique'],
            ['role','safe'],
            ['password2', 'compare','compareAttribute'=>'password','message'=>'两次密码输入不一致'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'token' => '自动登录令牌',
            'email' => '邮箱',
            'token_create_time' => '令牌创建时间',
            'add_time' => '注册时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录ip',
            'password2'=>'确认密码',
            'auth_key'=>'auth_key',
            'role'=>'角色',
        ];
    }
    //给用户添加角色,查出所有角色
    public static function getRoleOption()
    {
        $rs = Yii::$app->authManager->getRoles();
        return ArrayHelper::map($rs,'name','description');
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
        // TODO: Implement findIdentity() method.
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
        // TODO: Implement getId() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key===$authKey;
        // TODO: Implement validateAuthKey() method.
    }
    //管理菜单
    public function getMenuItems()
    {
        $menuItems = [];
        //查出所有一级分类
        $menus = Menu::find()->where(['parent_id'=>0])->all();
        //遍历放进数组$menuItems中
        foreach($menus as $menu){
             $items =[];
            //查出所有子类
            $rs = Menu::find()->where(['parent_id'=>$menu->id])->all();
            //遍历子类,一一放到数组中
            foreach($rs as $r){
                //判断该用户是否有权限
                if(Yii::$app->user->can($r->url)){
                    $items[]= ['label'=>$r->name,'url'=>[$r->url]];
                    //把数据放到$menuItems中
                    $menuItems[]=[
                        'label'=>$menu->name,
                        'items'=>$items,
                    ];
                }
            }

        }

        return $menuItems;
    }
}
