[git]:http://git-scm.com/download/
[BCompare]: http://www.scootersoftware.com/download.php

### 准备工作

* 安装[git][git]
* 安装[BCompare][BCompare]
* 把BCompare加入PATH
* 执行以下命令

```
# diff tool 配置 
git config --global diff.tool bc3
git config --global difftool.bc3.cmd 'BCompare "$LOCAL" "$REMOTE"'
git config --global difftool.prompt false

# merge tool 配置
git config --global merge.tool bc3
git config --global mergetool.bc3.cmd 'BCompare "$LOCAL" "$REMOTE" "$BASE" "$MERGED"'
git config --global mergetool.prompt false

# 克隆v3版本库
git clone git@gitlab.intra.tudou.com:static/v3.git

# 用户名 邮箱配置
git config user.name yourname --local
git config user.email yourname@tudou.com --local

```
### 创建和共享分支

* 切换到v3目录下

* 创建本地分支test `git branch test` 

* 切换到本地分支test `git checkout test`

* 推送本地分支test `git push origin test` (请确保你在test分支上)

注：基于共享分支创建本地分支`git branch test origin/test` 

### 修复bug

* `git add -A`

* `git commit -m "fix bug 10000"`

* 推送到服务器 `git push origin test` 

* 测试通过

### 合并分支

* 切换到master分支 `git checkout master`

* `git pull origin master` 获取master分支上的最新提交

* 合并test分支到master `git merge test`(请确保你在maser分支上)

* 如果冲突，先把dist 和 build的文件的冲突标记为解决，`git add -A dist/. build/.` 

* 然后解决其他目录下的文件冲突 `git mergetool`

* 构建 `ytpm path`

* `git add -A`

* `git commit -m "merger branch test for fixbug 10000"`

* 推送到共享版本库 `git push origin master`

* 测试通过, 坐等上线

### 删除分支

* `git branch -d test` 删除本地分支test

* `git push origin :test` 删除共享版本库分支test

### 切换分支时，如果工作目录有未提交内容的做法。

最简单方法是提交当前的改动，然后切换分支。 （如果不想把之前的改动作为一次提交，同样也是先提交，然后当你再次切换回来的时候执行`git reset HEAD^` 就可以把之前提交的内容撤出提交。

### tip

* `git gui &` 开启git图形化界面

* `gitk &` 开启git图形化界面（只能用来浏览）

* `git help [command] -w` 在浏览器里面显示git命令文档

* `git show commit:filename > otherfilename` 提取出某个commit下的文件到另外一个文件中

* `git checkout HEAD -- filename` revert 一个文件

* `git checkout commit -- filename` revert 一个文件 到某个版本



## git 基本用法

### 基本命令

* git config
* git init
* git clone
* git add
* git commit
* git branch
* git push
* git pull
* git checkout
* git reset
* git clean


### `git config`

项目配置
```
git config user.name yourname --local
git config user.email yourname@tudou.com --local
```

全局配置
```
git config user.name yourname --global
git config user.email yourname@youremail.com --global
```
* `git config unset key` 清空key的设置 


#### `git init` 

初始化一个git repertory

#### `git clone`

clone 一个git repertory, 例如 `git clone git@gitlab.intra.tudou.com:static/v3.git`

#### `git add`

添加文件到暂存区(提交列表)

* `git add -A` 添加所有有改动的文件，包含删除的文件,以及新增的文件(未追踪的文件)

* `git add -u` 添加所有有改动的文件，包含删除的文件，但不包含新增文件

* `git add -A -n` 仅列出要add的文件，不执行add操作 同`git add -A --dry-run`

* `git add -u -n` 同上

如果要指定文件夹 或者 文件 只需要在命令后面增加 `-- path`，如果是指定文件的 可以省去 `-A` `-u`

如果要添加存在于忽略列表(.gitignore)的文件，例如 

```
# .gitignore

test.js

```
如果要添加 test.js, 需要执行`git add test.js -f`

#### `git commit -m 'message'`

提交暂存区文件到版本库 `-m 'message'` 对提交的说明

`git commit -m 'message' --dry-run` 测试提交 

#### `git pull`

获取共享版本库的更新

* `git pull origin branch` 获取远程版本库分支的更新到本地当前分支，一般都会在`branch`分支上执行该命令
* `git pull origin branch:branch` 获取共享版本库的`branch`到本地的`branch`上，如果本地不存在`branch`分支 者创建该`branch`分支

最好在每次执行`git push` 之前执行一次`git pull`，当然如果你确定你当前这个分支没有其他人提交，可以直接push。

#### `git push`

推送到共享版本库

* `git push origin branch` 推送当前分支到共享版本库的`branch`分支上，一般都会在本地`branch`分支上执行该命令，如果共享版本库没有`branch`分支则创建`branch`分支

* `git push origin branch:branch` 推送本地`branch`分支到共享版本库的`branch`分支上，如果共享版本库没有`branch`分支则创建`branch`分支(可以用于修改共享版本库`branch`分支所指向的提交，最好不要用于修改)

* `git push origin branch1:branch2` 推送本地`branch1`分支到共享版本库的`branch2`分支上

* `git push origin :branch` 删除共享版版本库的`branch`分支

* `git push origin tag` 推送本地`tag`到共享版本库`tag`，创建(或者修改，最好不要用于修改)

* `git push origin tag:tag` 同上

* `git push tag1:tag2` 推送本地`tag`到共享版本库`tag2`，创建(或者修改，最好不要用于修改)

* `git push origin :tag` 删除共享版本库的tag

注：

一般我们不需要推送tag到共享版本库，tag应该有部门boss负责

#### `git branch`

查看分支，一般情况在修改和推送之前 要先确定你所在的分支，

* `git branch` 列出本地所有的分支 

* `git branch -r` 列出远程所有的分支

默认情况下clone的版本库都会把共享版本库的分支hash引用复制到本地，以方便创建分支

```
$ git branch
  maser
  master
* test
```

前面标记*的为当前所在分支

```
$ git branch -r
  origin/master
  origin/test1
```

上面表示共享版本库有 2个分支 一个为master  一个为 test1 你可以基于共享版本库分支创建本地分支，命令如下
`git branch test1 origin/test1` 如果你本地分支已经存在test1分支，你可以用其他名字`git branch newtest1 origin/test1`


创建分支

* `git branch test` 基于当前提交创建test分支

* `git branch test 020c077` 基于指定020c077 commit 创建test分支

* `git branch test tag` 基于指定tag创建test分支

* `git branch test origin/test` 基于共享版本库test分支创建test分支


注：一般我们只基于master分支创建分支，操作步骤

* 基于master创建`hotfix/nav`分支  `git branch hotfix/nav master`
* 切换到`hotfix/nav`分支 `git checkout hotfix/nav`
* 推送`hotfix/nav`分支到共享版本库 `git push origin hotfix/nav`
* 修复bug
* 提交修改 `git commit -m 'hotfix nav some bug'`
* 推送修改到共享版本库 `git push oringi hotfix/nav`

`git branch -d hotfix/nav` 删除本地`hotfix/nav`分支，删除共享版本库分支请用`git push origin :hotfix/nav`

#### `git checkout`

检出 checkout 分支时请确保工作区和暂存区 clean

* `git checkout` 汇总工作区 暂存区 HEAD的差异，和`git status -s`的输出差不多

* `git checkout HEAD` 同上

* `git checkout branch` 检出指定分支

* `git checkout -- filename`  用暂存区的filename文件覆盖工作区的filename文件 相当于撤销 最后一次add后的所有修改（危险,工作区的修改会被覆盖）

* `git checkout HEAD -- filename` revert 一个文件

* `git checkout commit -- filename` 用commit的filename文件覆盖 暂存区以及工作区的filenam文件 (危险，工作区的修改会被覆盖)

* `git checkout -- .` 用暂存区覆盖工作区，即清除没有add的改动，但不会清除未追踪的文件 （危险，工作区的修改会被覆盖）

最常用的一般是`git checkout -b branch` 创建branch分支并且切换到branch分支。

#### `git reset`

重置HEAD

`git reset HEAD` 撤销add操作，相当于执行 `git add -A` 的反向操作

`git reset HEAD -- filename` 把filename撤出暂存区


注： `git reset`  `git checkout` 有很多其他用法，请自己看文档吧。

#### `git clean`

* `git clean -n` 显示要清除的文件 相当于`git clean --dry-run`

* `git clean -fd` 清除未追踪的文件以及文件夹

* `git clean -f`  清除未追踪的文件

#### `git merge`

* `git merge branch` 合并branch分支到当前分支，通常我们在master分支上执行 合并开发分支到master上面

### difftool 和 mergetool 使用

大家一致推荐[BCompare]
```
#### 可选配置 合并成功后删除备份文件*.orig，但是建议不设置，请手动删除备份文件
git config --global mergetool.keepBackup false
```

#### difftool使用方法

* `git difftool -- filename` 对比filename 工作区版本和暂存区版本

* `git difftool --cached -- filename` 对比filename 暂存区版本和版本库版本

* `git difftool HEAD -- filename` 对比filename 工作区版本和版本库版本(HEAD)

* `git difftool commit1 commit2 --filename` 对比两个提交下的 文件差别

#### mergetool 使用方法

* `git mergetool`






 









 