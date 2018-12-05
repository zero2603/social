import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Card } from '../../components/Card';
import MessageItem from '../../components/Message/MessageItem';
import IncomingMessage from '../../components/Message/IncomingMessage';
import OutgoingMessage from '../../components/Message/OutgoingMessage';
// import io from 'socket.io-client';
import socket from '../../helper/socket';
import {vantutest} from '../../helper/socket';
import {
    getListChat,
    createConversation,
    DanhSach,
    changeListChast,
    loadMessage
} from "../../actions/MessageActions";
import {withRouter} from "react-router-dom";
import connect from "react-redux/es/connect/connect";
import {getCafeDetail} from "../../actions/CafeActions";
import axios from 'axios';
import chatApi from "../../api/chat";

// const socket = io('https://chat.noiduyen.vn:80/', {secure: true, reconnect: true});

class Messages extends Component {

    constructor(props) {
        super(props);
        this.state = {
            conversation: [],
            activeChat: {},
            current_message: '',
            typing: "",
            typingStatus: false,
            chatList: [],
            chatListClone: [],
        };

        if (this.props.current_user.id){
            var subcriber = {room_id: this.props.current_user.id, username: this.props.current_user.name};
            socket.emit('subscribe', subcriber);
        }
        this.messagesEnd = React.createRef();
    }

    enterMessage(evt){
        if (evt.key === 'Enter') {
            this.emitMessage();
        }
    }

    scrollToBottom() {

        const messagesEnd = this.messagesEnd.current;
        // console.log(messagesEnd);
        const scrollHeight = messagesEnd.scrollHeight;
        const height = messagesEnd.clientHeight;
        var maxScrollTop = scrollHeight - height;
        messagesEnd.scrollTop = maxScrollTop;
        // ReactDOM.findDOMNode(messagesEnd).scrollTop = maxScrollTop > 0 ? maxScrollTop : 0;
    }

    typingMessage(evt){
        var c11 = this.state.current_message;
        this.setState({
            current_message: evt.target.value
        }, () => {
        });

        if (evt.target.value.length > 0){
            socket.emit('typing', {to_id: [this.state.activeChat.id]});
        }
        if (evt.target.value.length === 0){
            socket.emit('stop_typing');
        }
    }

    emitMessage(){
        if (this.state.current_message === "") {
            alert("Gõ thông điệp đi bạn ");
            return;
        }
        socket.emit('new_message', {
            username: this.props.current_user.name,
            message : this.state.current_message,
            to_id: [this.state.activeChat.id],
            conversation_id: this.state.activeChat.conversation_id,
        })
        this.setState({
            current_message: "",
        }, () => {
            socket.emit('stop_typing');
            this.setState({typing: ""});
        });
    }

    changeActive(item){
        // console.log(item);
        if (!item.conversation_id) {
            this.props.createConversation({
                name: item.id + "_" + this.props.current_user.id,
                creator_id: this.props.current_user.id,
                user: [this.props.current_user.id, item.id]
            })
                .then(response => {
                    var payload = {
                        index: null,
                        conversation_id: response.conversation_id,
                        last_message: "Welcome NOIDUYEN :)"
                    };
                    for(let i = 0; i < this.props.chatList.length; i ++){
                        if (this.props.chatList[i].id == this.state.activeChat.id){
                            payload.index = i;
                            break;
                        }
                    }
                    this.props.loadMessage({conversation_id: response.conversation_id})
                        .then(response => {
                            this.setState({
                                conversation: response,
                            }, () => {
                                this.scrollToBottom();
                            });
                            // console.log(response);
                        })
                    this.props.changeListChast(payload)
                        .then(resState => {
                            // do nothing
                        })
                })
        } else {
            this.setState({
                activeChat: item,
            })
            this.props.loadMessage({conversation_id: item.conversation_id})
                .then(response => {
                    this.setState({
                        conversation: response,
                    },() => {
                        this.scrollToBottom();
                    });
                })
        }

    }

    searchUser(e){
        const value = e.target.value;
        var newData = [];
        for(let i = 0; i < this.props.chatList.length; i ++) {
            var data = this.props.chatList[i];

            if (data.name.toLowerCase().includes(value.toLowerCase()) === true) {
                newData.push(data);
            }
        }
        this.setState({
            chatList: newData
        });
    }

    componentDidMount(){

        this.scrollToBottom();

        socket.on("notify", (data) => {
            console.log("Data return la = ");
            console.log(data);
        })

        this.props.getListChat()
            .then(response => {

                for (let i = 0; i < response.length; i++ ){
                    if (response[i].id !== this.props.current_user.id){
                        this.setState({
                            activeChat: response[i],
                            chatList: response,
                            chatListClone: response
                        }, () => {

                            this.props.loadMessage({conversation_id: this.state.activeChat.conversation_id})
                                .then(response => {
                                    this.setState({
                                        conversation: response
                                    }, () => {
                                        this.scrollToBottom();
                                    });
                                })

                        })
                        break;
                    }
                }
            })

        // Lang nghe xem co tin nhan moi khoong

        socket.on("new_message", (data) => {

            if (data.conversation_id === this.state.activeChat.conversation_id)
            {
                this.state.conversation.push(
                    {
                        user_id: data.user_id,
                        content: data.message,
                        created_at: '20-11-2018'
                    }
                );
            }

            const dataMess = {conversation_id: data.conversation_id, last_message: data.message};
            for(let i = 0; i < this.props.chatList.length; i ++){
                if (this.props.chatList[i].conversation_id === data.conversation_id){
                    this.props.changeListChast(dataMess)
                        .then(resState => {
                            // console.log(resState);
                            this.setState({
                                status: Math.random()
                            })
                        })
                }
            }


        })

        socket.on('typing', (data) => {
            if (data.user_id === this.state.activeChat.id){
                this.setState({
                    typing: data.username + " typing ..."
                })
            }
        })

        socket.on('stop_typing', (data) => {
            if (data.user_id === this.state.activeChat.id){
                this.setState({
                    typing: "",
                })
            }
        })
    }

    render() {

        var sampleData = {
            message: {
                sender: {
                    name: "Pham Anh Thu",
                    avatar: "https://www.w3schools.com/howto/img_avatar.png"
                },
                date: "01/11/2018",
                content: "Test, which is a new approach to have all solutions astrology under one roof."
            }
        }


        return (
            <Card>
                <div className="messaging">
                    <div className="inbox_msg">
                        <div className="inbox_people">
                            <div className="headind_srch">
                                <div className="recent_heading">
                                    <ul>
                                        <li className={'active'}>
                                            <a href={'#'} onClick={() => {console.log(this.props.chatList)}}>Tất cả</a>
                                        </li>
                                        <li>
                                            <a href={'#'} onClick={(e) => {e.preventDefault()}}>Chưa đọc</a>
                                        </li>
                                        <li>
                                            <a href={'#'} onClick={() => {console.log(this.props.chatList)}}>Online</a>
                                        </li>
                                        <li>
                                            <a href={'#'} onClick={(e) => {
                                                this.scrollToBottom();
                                                e.preventDefault();
                                            }}>Star</a>
                                        </li>
                                    </ul>

                                    <input type={'text'}
                                           onChange={(e) => {this.searchUser(e)}}
                                           name={'search'}
                                           className="form-control"
                                           placeholder={"Tìm kiếm theo tên"} />

                                </div>
                            </div>
                            <div className="inbox_chat">
                                {
                                    this.state.chatList.map(item => {
                                        if (item.id === this.props.current_user.id){

                                        }else{
                                            var lastMessage = {
                                                message: {
                                                    sender: {
                                                        name: item.name,
                                                        avatar: "https://www.w3schools.com/howto/img_avatar.png"
                                                    },
                                                    date: "01/11/2018",
                                                    content: item.content
                                                }
                                            }
                                            return (
                                                <MessageItem
                                                    key={item.id}
                                                    message={lastMessage.message}
                                                    isActive={item.id === this.state.activeChat.id}
                                                    unRead={false}
                                                    changeActive={() => {
                                                        this.changeActive(item);
                                                    }}
                                                />
                                            )
                                        }

                                    })
                                }
                            </div>
                        </div>
                        <div className="mesgs">
                            <div>
                                <img src="https://www.w3schools.com/howto/img_avatar.png" id="sender-avatar" />
                                <span className="h4">
                                    {this.state.activeChat.id?this.state.activeChat.name:"Loading ..."}
                                </span>
                                <div className="float-right">
                                    <i className="fas fa-ellipsis-h"></i>
                                </div>
                            </div>
                            <hr />
                            <div className="msg_history" ref={this.messagesEnd}>
                                {
                                    this.state.conversation.map((item, index)=> {
                                        return (
                                            <div key={index}>
                                                {
                                                    (item.user_id === this.props.current_user.id) ? (
                                                        <IncomingMessage
                                                            message={item}
                                                        />
                                                    ) : (
                                                            <OutgoingMessage
                                                                message={item}
                                                            />
                                                        )
                                                }
                                            </div>
                                        )
                                    })
                                }

                                <div className={"endconversation"} style={{ float:"left", clear: "both" }}>
                                </div>

                            </div>
                            <p>{this.state.typing}</p>
                            <div className="type_msg">
                                <div className="input_msg_write">
                                    <input type="text"
                                           value={this.state.current_message}
                                           className="write_msg"
                                           id="input-msg"
                                           placeholder="Type a message"
                                           onChange={(evt) => this.typingMessage(evt)}
                                           onKeyPress={(evt) => this.enterMessage(evt)}
                                    />

                                    <button onClick={() => { this.emitMessage() }} className="msg_send_btn" type="button">
                                        <i className="fa fa-paper-plane-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Card>
        );
    }
}


function mapStateToProps(state) {
    return {
        current_user: state.user.current_user,
        chatList: state.chat.chatList
    }
}

function mapDispatchToProps(dispatch) {
    return {
        getListChat: (id) => dispatch(getListChat()),
        createConversation: (data) => dispatch(createConversation(data)),
        DanhSach: (id) => dispatch(DanhSach()),
        changeListChast: (data) => dispatch(changeListChast(data)),
        loadMessage: (data) => dispatch(loadMessage(data))
    }
}

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Messages));

// export default Messages;