<?php include '../app/views/inc/header.inc.php'; ?>
<?php $userTasks = $data['userTasks']; ?>
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <div class="mt-3">
                <?php if(!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger text-center py-2 mb-2"><?= $_SESSION['error']; ?></div>
                <?php unset($_SESSION['error']); endif; ?>
                <?php if(!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success text-center py-2 mb-2"><?= $_SESSION['success']; ?></div>
                <?php unset($_SESSION['success']); endif; ?>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Add a task</h4>
                </div>
                <div class="card-body">
                    <form action="<?=ROOT?>task/<?= !empty($_SESSION['edittask_id']) ? 'update' : 'add' ?>" method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="task" placeholder="Write something..." value="<?= !empty($_SESSION['edittask_task']) ? $_SESSION['edittask_task'] : '' ?>" autocomplete="off" autofocus required>
                        </div>
                        <div class="mb-3">
                            <?php if(!empty($_SESSION['edittask_id'])): ?>
                                <button type="submit" class="btn btn-secondary float-right" name="btnCancelUpdate">Cancel</button>
                            <?php endif; ?>
                            <button type="submit" class="btn <?= !empty($_SESSION['edittask_id']) ? 'btn-outline-secondary' : 'btn-secondary' ?> float-end" name="<?= !empty($_SESSION['edittask_id']) ? 'btnTaskUpdate' : '' ?>">
                                <?= !empty($_SESSION['edittask_id']) ? 'Update' : 'Save' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <?php if(count($userTasks) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover" id="userTasksTable" class="display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-white">#</th>
                                <th class="text-white">Task</th>
                                <th class="text-white">Status</th>
                                <th class="text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; foreach($userTasks as $userTask): $no++; ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $userTask['task']; ?></td>
                                <td><?= ($userTask['status'] == 0) ? "Pending" : "Done"; ?></td>
                                <td>
                                    <form action="<?= ROOT ?>task/edit" method="POST" class="d-block d-lg-inline mb-1 mb-lg-0">
                                        <button class="btn btn-secondary" name="id" value="<?= $userTask['id']; ?>" <?= ($userTask['status'] == 0 && !isset($_SESSION['edittask_id'])) ? "" : "disabled"; ?>><img src="<?=ASSETS?>svg/edit.svg" alt="Edit Icon" width="20" height="20" title="Edit Task"></button>
                                    </form>
                                    <form action="<?= ROOT ?>task/done" method="POST" class="d-block d-lg-inline mb-1 mb-lg-0">
                                        <button class="btn btn-secondary" name="id" value="<?= $userTask['id']; ?>" <?= ($userTask['status'] == 0 && !isset($_SESSION['edittask_id'])) ? "" : "disabled"; ?>><img src="<?=ASSETS?>svg/check.svg" alt="Check Icon" width="20" height="20" title="Mark as Done"></button>
                                    </form>
                                    <form action="<?= ROOT ?>task/delete" method="POST" class="d-block d-lg-inline mb-1 mb-lg-0">
                                        <button class="btn btn-secondary" name="id" value="<?= $userTask['id']; ?>" onclick="return confirm('Are you sure you want to delete task: <?= $userTask['task']; ?>?');" <?= (!isset($_SESSION['edittask_id'])) ? "" : "disabled"; ?>><img src="<?=ASSETS?>svg/trash.svg" alt="Trash Icon" width="20" height="20" title="Delete Task"></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            <?php else: ?>
            <div class="mb-3 text-center">
                <p>You have not entered a task yet.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include '../app/views/inc/footer.inc.php'; ?>