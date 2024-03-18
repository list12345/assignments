<?php

namespace Users\Controllers;

use Users\Models\User;

/**
 * Class UserController
 */
class UsersController
{
    /**
     * @return array[]
     */
    public function permissions(): array
    {
        return [
            'admin' => ['list', 'create', 'update', 'delete', 'view'],
            'user' => ['list',],
            'guest' => ['list'],
        ];
    }

    /**
     * @param string $action
     *
     * @return void
     * @throws \Exception
     */
    protected function authorize(string $action): void
    {
        /** @var User $user */
        $user = $_SESSION['user'];
        $permissions = $this->permissions();
        $role = $user instanceof User ? $user->role : 'guest';
        if (!in_array($action, $permissions[$role])) {
            throw new \Exception('Not Authorize');
        }
    }

    /**
     * User List (it needs pagination)
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionList()
    {
        $this->authorize('list');
        $rows = (new User())->findAll();

        $this->render('views/list', [
            'rows' => $rows,
        ]);
    }

    /**
     * @param $id
     *
     * @return \Users\Models\DBModel|null
     * @throws \Exception
     */
    protected function findModel($id)
    {
        if (($model = (new User())->find($id)) === null) {
            throw new \Exception('Not Found', 404);
        }

        return $model;
    }

    /**
     * Creates a new User.
     * If creation is successful, the browser will be redirected to the 'list' page.
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $this->authorize('create');
        $model = new User();
        if ($model->load($_POST)) {
            $model->state = User::STATE_NEW;
            $model->scenario = 'create';
            if ($model->validate()) {
                /** simple md5 */
                $model->password_hash = md5($model->password . User::SALT);
                if ($model->save()) {
                    return $this->redirect(['list']);
                }
            }
        }

        $this->render('views/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'list' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $this->authorize('update');
        $model = $this->findModel($id);
        if ($model->load($_POST) && $model->validate()) {
            if ($model->save()) {
                // if success
                return $this->redirect(['list']);
            }
        }

        $this->render('views/update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $this->authorize('delete');
        $model = $this->findModel($id);
        // soft deletion
        $model->state = User::STATE_DELETED;
        if ($model->save()) {
            return $this->redirect(['list']);
        }
        throw new \Exception('Internal Error', 500);
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionView($id)
    {
        $this->authorize('view');
        $model = $this->findModel($id);

        $this->render('views/view', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $path
     * @param array $params
     *
     * @return void
     */
    public function render(string $path, array $params)
    {
        include(dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . $path . '.php');
    }

    /**
     * @param array $route
     *
     * @return string
     */
    public function redirect(array $route): void
    {
        ob_start();
        header('Location: ' . $route[0] ?? ''); // need to add params
        ob_end_flush();
    }
}
