<template>
    <el-dialog title="确认操作" v-model="payType.sureFormVisible" :close-on-click-modal="false">
        <el-form :model="sureForm" label-width="120px" :rules="sureFormRules" ref="sureForm">
            <el-input type="hidden" prop="tHetongId"  v-model="payType.tHetongId" auto-complete="off"></el-input>
            <el-form-item label="佣金支付方式" prop="yjZfType">
                <el-radio-group v-model="sureForm.yjZfType">
                    <el-radio class="radio"  :label=0>业主支付</el-radio>
                    <el-radio class="radio" :label=1>幼狮代付</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click.native="payType.sureFormVisible = false">取消</el-button>
            <el-button type="primary" @click.native="sureSubmit" :loading="sureLoading">确认</el-button>
        </div>
    </el-dialog>
</template>
<script>


    import {
        selectCommissionPayType,
    } from '../../api/api';

    export default{
        props:['payType'],
        data(){
            return {

                // sureFormVisible: true,//确认界面是否显示
                sureLoading: false,
                sureFormRules: {
                    yjZfType:[
                        {required: true,validator:(rule,value,callback)=>{
                            if(/^\d+$/.test(value) == false){
                                callback(new Error("佣金支付方式不能为空"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                },
                //确认界面数据
                sureForm: {
                    yjZfType:0,
                    tHetongId:0,
                },
            }
        },
        methods:{

            //确认
            sureSubmit: function () {
                this.$refs.sureForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.sureLoading = true;
                            let hetongId = {
                                tHetongId:this.payType.tHetongId,
                            }
                            let para = Object.assign({}, this.sureForm,hetongId);

                            selectCommissionPayType(para).then((res) => {
                                this.sureLoading = false;
                                //alert(JSON.stringify(res));
                                if(res.data.code=='200')
                                {
                                    //alert(0);
                                    this.$message({
                                        message: '提交成功' ,
                                        type:'success'
                                    });
                                }else{
                                    this.$message({
                                        message: res.data.msg ,
                                        type:'error'
                                    });
                                }

                                this.$refs['sureForm'].resetFields();
                                this.sureFormVisible = false;
                                // this.getBrokerCompany();
                            });
                        });
                    }
                });
            },
        },
        mounted() {

        }
    }
</script>
