<template>
    <el-form style="margin-top:2%" :model="copyForm" ref="copyForm" :rules="copyRules" label-position="top">
            <el-form-item label="合同" prop="iscompletehetong" >
                <el-radio-group v-model="copyForm.iscompletehetong">
                    <el-radio :label=1>全</el-radio>
                    <el-radio :label=0>不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-upload
                    action="/purchaseContract/addCopyImage?type=1"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="hetongList"
                    :before-upload="beforeAvatarUpload"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
            <div v-if="yezhuleixing==1">
                <el-form-item label="产权人身份证"  prop="iscompletecqrsfz" >
                    <el-radio-group v-model="copyForm.iscompletecqrsfz">
                        <el-radio :label=1>全</el-radio>
                        <el-radio :label=0>不全</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-upload
                        action="/purchaseContract/addCopyImage?type=2"
                        list-type="picture-card"
                        :headers="headers"
                        :data="data"
                        multiple
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :on-success="handleSuccess"
                        :file-list="chanquanrenList"
                >
                    <i class="el-icon-plus"></i>
                </el-upload>
                <el-dialog v-model="dialogVisible" size="tiny">
                    <img width="100%" :src="dialogImageUrl" alt="">
                </el-dialog>
            </div>

        <div v-if="yezhuleixing==2">
            <el-form-item label="营业执照"  prop="iscompleteyyzz">
                    <el-radio-group v-model="copyForm.iscompleteyyzz">
                        <el-radio :label=1>全</el-radio>
                        <el-radio :label=0>不全</el-radio>
                    </el-radio-group>
                </el-form-item>
            <el-upload
                    action="/purchaseContract/addCopyImage?type=3"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="yingyezhizhao"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </div>

        <div v-if="yezhuleixing==2">
            <el-form-item label="法人证件"  prop="iscompletefrzz">
                    <el-radio-group v-model="copyForm.iscompletefrzz">
                        <el-radio :label=1>全</el-radio>
                        <el-radio :label=0>不全</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-upload
                        action="/purchaseContract/addCopyImage?type=4"
                        list-type="picture-card"
                        :headers="headers"
                        :data="data"
                        multiple
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :on-success="handleSuccess"
                        :file-list="faren"
                >
                    <i class="el-icon-plus"></i>
                </el-upload>
                <el-dialog v-model="dialogVisible" size="tiny">
                    <img width="100%" :src="dialogImageUrl" alt="">
                </el-dialog>
        </div>

        <el-form-item label="房产证" prop="iscompletefcz" >
            <el-radio-group v-model="copyForm.iscompletefcz">
                <el-radio :label=1>全</el-radio>
                <el-radio :label=0>不全</el-radio>
            </el-radio-group>
        </el-form-item>
        <el-upload
                action="/purchaseContract/addCopyImage?type=5"
                list-type="picture-card"
                :headers="headers"
                :data="data"
                multiple
                :on-preview="handlePictureCardPreview"
                :on-remove="handleRemove"
                :on-success="handleSuccess"
                :file-list="fangchanzheng"
        >
            <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog v-model="dialogVisible" size="tiny">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>

        <el-form-item label="不动产授权委托书" prop="" >
            <el-radio-group v-model="copyForm.iscompletebdcsqwts">
                <el-radio :label=1>全</el-radio>
                <el-radio :label=0>不全</el-radio>
            </el-radio-group>
        </el-form-item>
        <el-upload
                action="/purchaseContract/addCopyImage?type=6"
                list-type="picture-card"
                :headers="headers"
                :data="data"
                multiple
                :on-preview="handlePictureCardPreview"
                :on-remove="handleRemove"
                :on-success="handleSuccess"
                :file-list="budongchan"
        >
            <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog v-model="dialogVisible" size="tiny">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>

        <el-form-item label="业主授权代理人委托书" prop="" >
            <el-radio-group v-model="copyForm.iscompleteyzsqdlrwts">
                <el-radio :label=1>全</el-radio>
                <el-radio :label=0>不全</el-radio>
            </el-radio-group>
        </el-form-item>
        <el-upload
                action="/purchaseContract/addCopyImage?type=7"
                list-type="picture-card"
                :headers="headers"
                :data="data"
                multiple
                :on-preview="handlePictureCardPreview"
                :on-remove="handleRemove"
                :on-success="handleSuccess"
                :file-list="yezhushouquan"
        >
            <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog v-model="dialogVisible" size="tiny">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>

            <el-form-item label="委托人身份证" prop="" >
                <el-radio-group v-model="copyForm.iscompletewtrsfz">
                    <el-radio :label=1>全</el-radio>
                    <el-radio :label=0>不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-upload
                    action="/purchaseContract/addCopyImage?type=8"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="weituoren"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>

            <el-form-item label="房屋交割单" prop="" >
                <el-radio-group v-model="copyForm.iscompletefwjgd">
                    <el-radio :label=1>全</el-radio>
                    <el-radio :label=0>不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-upload
                    action="/purchaseContract/addCopyImage?type=9"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="jiaogedan"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        <div style="position: fixed;right:10%;top:50%;">
            <el-button type="primary"   @click="save" style="margin-top:100px;">保存</el-button>
            <el-button type="warning"   @click="cansel" style="margin-top:100px;">取消</el-button>
        </div>

    </el-form>
</template>
<script>
    import {
        copyImageList,
        copyImageDelete,
        isCopyComplete,
        isCopyCompleteList,
        getPurchaseContractInfo,
    } from  '../../api/api';

    export default {
        data() {
            return {
                copyRules:{
                    iscompletehetong: [
                        { required: true, message: '不能为空' }
                    ],
                },
                copyForm:{
                    iscompletehetong:null,
                    iscompletecqrsfz: null,
                    iscompleteyyzz:null,
                    iscompletefrzz:null,
                    iscompletefcz:null,
                    iscompletebdcsqwts:null,
                    iscompleteyzsqdlrwts:null,
                    iscompletewtrsfz:null,
                    iscompletefwjgd:null,
                },
                hetongList: [],
                chanquanrenList: [],
                yingyezhizhao:[],
                faren:[],
                fangchanzheng:[],
                budongchan:[],
                yezhushouquan:[],
                weituoren:[],
                jiaogedan:[],
                yezhuleixing:null,
                dialogImageUrl: '',
                dialogVisible: false,
                headers:{
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                },
                data:{
                    id:null,
                },
            };
        },
        methods: {
            save(){
                this.$refs.copyForm.validate((valid) => {
                    if(valid){
                        let para = Object.assign({}, this.copyForm,{id:parseInt(this.$route.query.id)});
                        isCopyComplete(para).then((res)=>{
                            if(res.data.code=='200'){
                                this.$message({
                                    message: '保存成功',
                                    type: 'success'
                                });
                                history.go(-1);
                            }else{
                                this.$message({
                                    message: res.data.msg,
                                    type: 'error'
                                });
                            }

                        });
                    }
                });

            },
            cansel(){
                history.go(-1);
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;
                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },
            handleRemove(file, fileList) {
                let para ={
                    id :file.id,
                }
                copyImageDelete(para).then((res)=>{

                });
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            handleSuccess(response, file, fileList){
                //响应值
                console.log(response)
            },
            getCopyImageList(){
                let para = {
                    id:this.$route.query.id
                }
                copyImageList(para).then((res)=>{
                    if(res.data.code=='200'){
                        this.hetongList = res.data.data[1];//合同
                        this.chanquanrenList = res.data.data[2];//合同
                        this.yingyezhizhao = res.data.data[3];//合同
                        this.faren  = res.data.data[4];//合同
                        this.fangchanzheng = res.data.data[5];//合同
                        this.budongchan = res.data.data[6];//合同
                        this.yezhushouquan = res.data.data[7];//合同
                        this.weituoren = res.data.data[8];//合同
                        this.jiaogedan = res.data.data[9];//合同
                    }
                })
            },
        },
        mounted(){
            this.data.id = this.$route.query.id;
            getPurchaseContractInfo(this.$route.query).then((res)=>{
                //查数据，得业主leixing
                this.yezhuleixing = res.data.data.yezhuleixing;
            }),
            isCopyCompleteList(this.$route.query).then((res)=>{
                //查数据，得业主leixing
                this.copyForm = res.data.data;
            })
            this.getCopyImageList();
        }


    }
</script>