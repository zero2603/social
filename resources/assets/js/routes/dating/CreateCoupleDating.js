import React, { Component } from 'react';
import { Card, CardWithTitle } from '../../components/Card';
import { getAllProvinces, getAllDistricts } from '../../actions/AddressActions';
import { getAllCafe } from '../../actions/CafeActions';
import { createCoupleEvent } from "../../actions/EventActions";
import connect from 'react-redux/es/connect/connect';
import Slider from "react-slick";
import { RoundAvatar } from '../../components/Avatar';
import Heading from '../../components/Information/Heading';
import { withRouter, Link } from 'react-router-dom';
import NotFound from '../404';
import Modal from 'react-modal';
import moment from 'moment';
import Select from 'react-select';
import 'moment/locale/vi.js';
import { DatePickerInput } from 'rc-datepicker';
import NumericInput from 'react-numeric-input';
import TimePicker from 'react-times';
import ToggleDisplay from 'react-toggle-display';
import CurrentUserLayout from '../profile/CurrentUserLayout';

class CreateCoupleDating extends Component {
    constructor(props) {
        super(props);
        var invitee = props.location.state ? props.location.state.invitee : null;
        var subscriber = props.location.state ? props.location.state.subscriber : null;
        this.state = {
            isOpenSuccess: false,
            event: {
                type: "couple",
                agency_id: subscriber ? subscriber.agency_id : null,
                name: subscriber ? subscriber.agency_name : null,
            },
            event_meta: {
                payer: subscriber ? ((subscriber.payer !== 'self') ? props.user.id : invitee.id) : invitee.id
            },
            startDate: new Date(),
            startTime: moment().hour() + 1 + ":00",
            selectedTheme: -1,
            invitee: invitee,
            subscriber: subscriber,
            province: null,
            district: null,
            agency_type: null,
            fee: 0,
            isShow: false
        }
    }

    componentDidMount() {
        this.props.getAllProvinces();
        if (this.state.subscriber) {
            this.props.getAllDistricts(this.state.subscriber.province_id);
            this.props.getAllCafe({
                province_id: this.state.subscriber.province_id,
                district_id: this.state.subscriber.district_id
            }).then((cafes => {
                cafes.forEach((cafe, index) => {
                    if (cafe.id === this.state.subscriber.agency_id) {
                        this.setState({
                            selectedAddress: index,
                            themes: cafe.images,
                            selectedTheme: -1,
                            fee: cafe.organizing_fee
                        });
                        return;
                    }
                });


            }));
        }
    }

    onChangeCafeFilter(selectedOption, filterType) {
        this.setState({
            [filterType]: selectedOption.value
        });

        switch (filterType) {
            case 'province': {
                this.props.getAllDistricts(selectedOption.value);
                this.props.getAllCafe({ province_id: selectedOption.value });
                this.setState({
                    event: {
                        ...this.state.event,
                        agency_id: null
                    },
                    district: null
                });
                break;
            }
            case 'district': {
                this.props.getAllCafe({ province_id: this.state.province, district_id: selectedOption.value });
                this.setState({
                    event: {
                        ...this.state.event,
                        agency_id: null
                    }
                });

                break;
            }
            case 'type': {
                this.props.getAllCafe({
                    province_id: this.state.province,
                    district_id: this.state.district,
                    type: selectedOption.value
                });
                break;
            }
        }
    }

    selectAddress(selectedOption) {
        this.setState({
            // selectedAddress: index,
            selectedTheme: -1,
            event: {
                ...this.state.event,
                agency_id: selectedOption.value,
                name: selectedOption.label,
                image: ""
            },
            themes: selectedOption.images,
            fee: selectedOption.fee
        })
    }

    selectTheme(item, index) {
        this.setState({
            selectedTheme: index,
            event: {
                ...this.state.event,
                image: item
            }
        });
    }

    onChangeDate(name, value) {
        this.setState({
            ...this.state,
            [name]: value
        })
    }

    onChangeData(e) {
        this.setState({
            event_meta: {
                [e.target.name]: e.target.value
            }
        })
    }

    onChangeTime(value, name) {
        if (new Date(new Date(this.state.startDate).setHours(value.hour)).setMinutes(value.minute) <= new Date()) {
            alert("Bạn không thể chọn ngày giờ nhỏ hơn hiện tại!");
            return;
        } else {
            this.setState({
                ...this.state,
                [name]: value.hour + ":" + value.minute
            })
        }
    }

    closeAlert() {
        this.setState({ isOpenSuccess: false }, () => {
            this.props.history.push('/dating');
        });
    }

    submit(e) {
        e.preventDefault();

        // if (!this.state.event.agency_id) {
        //     return alert("Địa chỉ quán không hợp lệ, vui lòng xem lại!");
        // }

        // if (this.state.selectedTheme < 0) {
        //     return alert("Vui lòng chọn lại chủ đề hoặc địa chỉ");
        // }

        if (!moment(this.state.start_time).isValid()) {
            return alert("Ngày bạn chọn không hợp lệ!");
        }


        var times = this.state.startTime.split(":");
        var start_time = moment(this.state.startDate).hour(times[0]).minute(times[1]);
        start_time = start_time.local().format('YYYY-MM-DD HH:mm:ss');

        this.props.createCoupleEvent({
            event: {
                ...this.state.event,
                limit_time_register: start_time,
                start_time: start_time,
                schedule_id: 0,
                payment_m: 0,
                payment_f: 0,
                is_secret: 0,
            },
            event_meta: {
                ...this.state.event_meta,
                job_conditional: [this.props.location.state.invitee.job],
                min_male_number: 1,
                max_male_number: 1,
                min_female_number: 1,
                max_female_number: 1
            },
            subscriber: this.props.location.state.invitee.id
        }).then(res => {
            this.setState({ isOpenSuccess: true });
        });

    }

    render() {
        var { cafes, price, provinces, districts, user } = this.props;
        var { invitee, subscriber } = this.state;

        var provinceOptions = provinces.map(province => {
            return { value: province.matp, label: province.name }
        });

        var districtOptions = districts.map(district => {
            return { value: district.maqh, label: district.name }
        });

        var cafeOptions = cafes.map(cafe => {
            return { value: cafe.id, label: cafe.name, images: cafe.images, fee: cafe.organizing_fee }
        });

        var typeOptions = [
            { value: 1, label: "Cafe" },
            { value: 2, label: "Quán ăn" }
        ];

        if (subscriber) {
            var selectedType = typeOptions.find(o => { return o.value === subscriber.agency_type });
        }

        //setting for slider
        var settings = {
            accessibility: true,
            dots: false,
            infinite: false,
            speed: 500,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true
        };

        if (!invitee) {
            return (
                <NotFound></NotFound>
            )
        }

        return (
            <div className="row">
                <main className="col col-xl-7 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                    <CardWithTitle title="TẠO CUỘC HẸN ĐÔI" hasLine={true}>
                        <form onSubmit={(e) => this.submit(e)}>
                            <div className="form-group">
                                <label>
                                    <b><i className="fas fa-map-marker-alt"></i> Địa điểm dành cho cuộc hẹn</b>
                                </label>
                                <div className="row d-flex align-items-center">
                                    <div className="col-3">
                                        <input
                                            className="custom-input"
                                            name="address" type="radio"
                                            onClick={() => {this.setState({isShow: true})}}
                                            required
                                        />
                                    </div>
                                    <div className="col-3">
                                        <label>Bạn chọn</label>
                                    </div>
                                    <div className="col-3">
                                        <input
                                            className="custom-input"
                                            name="address" type="radio"
                                            onClick={() => {this.setState({isShow: false})}}
                                            defaultChecked
                                            required
                                        />
                                    </div>
                                    <div className="col-3">
                                        <label>Người kia chọn</label>
                                    </div>
                                </div>
                                <ToggleDisplay show={this.state.isShow}>
                                    <div className="mb-4">
                                        Bạn có thể dùng bộ lọc tỉnh, huyện và loại quán để tìm địa điểm hẹn hò nhé!
                                    </div>
                                    <div className="row">
                                        <div className="col-12 col-md-4 mb-2">
                                            <Select
                                                placeholder="Chọn tỉnh/thành"
                                                options={provinceOptions}
                                                defaultValue={subscriber ? { value: subscriber.province_id, label: subscriber.province_name } : null}
                                                onChange={(selectedOption) => this.onChangeCafeFilter(selectedOption, "province")}
                                            />
                                        </div>
                                        <div className="col-12 col-md-4 mb-2">
                                            <Select
                                                placeholder="Chọn huyện"
                                                defaultValue={subscriber ? { value: subscriber.district_id, label: subscriber.district_name } : null}
                                                options={districtOptions}
                                                onChange={(selectedOption) => this.onChangeCafeFilter(selectedOption, "district")}
                                            />
                                        </div>
                                        <div className="col-12 col-md-4 mb-2">
                                            <Select
                                                placeholder="Loại quán"
                                                defaultValue={subscriber ? selectedType : null}
                                                options={typeOptions}
                                                onChange={(selectedOption) => this.onChangeCafeFilter(selectedOption, "type")}
                                            />
                                        </div>
                                        <div className="col-12 col-md-12 mb-4">
                                            <Select
                                                placeholder={`Danh sách các quán (${cafes.length} quán)`}
                                                defaultValue={subscriber ? { value: subscriber.agency_id, label: subscriber.agency_name } : null}
                                                options={cafeOptions}
                                                onChange={(selectedOption) => this.selectAddress(selectedOption)}
                                            />
                                        </div>
                                    </div>
                                </ToggleDisplay>
                                <React.Fragment>

                                    {
                                        (this.state.themes) ? (
                                            <React.Fragment>
                                                <h5>Chọn chủ đề cho cuộc hẹn của bạn</h5>
                                                <Slider {...settings}>
                                                    {
                                                        this.state.themes.map((item, index) => {
                                                            return (
                                                                <div className="event-theme" key={index}>
                                                                    <img
                                                                        src={item}
                                                                        className={this.state.selectedTheme == index ? `selected-image` : ``}
                                                                        onClick={() => this.selectTheme(item, index)}
                                                                    />
                                                                </div>
                                                            )
                                                        })
                                                    }
                                                </Slider>
                                            </React.Fragment>
                                        ) : null
                                    }
                                    <div className="row">
                                        <div className="col-md-4">Phí địa điểm tổ chức</div>
                                        <div className="col-md-8">
                                            <input type="text" className="form-control" readOnly value={this.state.fee + " VND"} />
                                        </div>
                                    </div>
                                </React.Fragment>
                                <div className="form-group">
                                    <label>
                                        <b>
                                            <i className="fas fa-stopwatch"></i> Chọn thời gian hẹn
                                        </b>
                                    </label>
                                    <div className="row">
                                        <div className="col-12 col-md-6">
                                            <DatePickerInput
                                                minDate={subscriber ? moment(Math.max(new Date(subscriber.expect_date_from), new Date())) : moment()}
                                                maxDate={subscriber ? moment(subscriber.expect_date_to) : moment(new Date().setDate(new Date().getDate() + 15))}
                                                className='react-datepicker-component my-react-component'
                                                value={this.state.startDate}
                                                onChange={(date) => this.onChangeDate("startDate", date)}
                                                locale='vi'
                                                showOnInputClick={true}
                                            />
                                        </div>
                                        <div className="col-12 col-md-6">
                                            <TimePicker
                                                time={this.state.startTime}
                                                theme="classic"
                                                timeConfig={{
                                                    from: '07:00 AM',
                                                    to: '09:00 PM',
                                                    step: 15,
                                                    unit: 'minute'
                                                }}
                                                onTimeChange={(value) => this.onChangeTime(value, "startTime")}
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label>
                                        <b><i className="fas fa-dollar-sign"></i> Người thanh toán cuộc hẹn</b>
                                    </label>
                                    {/* Ngược với giá trị bản ghi, nếu payer=self tức là người kia nhận trả */}
                                    <div className="row d-flex align-items-center">
                                        <div className="col-3">
                                            <input
                                                className="custom-input"
                                                name="payer" type="radio" value="self"
                                                defaultChecked={subscriber ? subscriber.payer !== 'self' : true}
                                                onClick={() => {
                                                    this.setState({event_meta: {...this.state.event_meta, payer: user.id}})
                                                }}
                                                required
                                            />
                                        </div>
                                        <div className="col-3">
                                            <label>Bạn</label>
                                        </div>
                                        <div className="col-3">
                                            <input
                                                className="custom-input"
                                                name="payer" type="radio" value="partner"
                                                defaultChecked={subscriber ? subscriber.payer === 'self' : false}
                                                onClick={() => {
                                                    this.setState({event_meta: {...this.state.event_meta, payer: invitee.id}})
                                                }}
                                                required
                                            />
                                        </div>
                                        <div className="col-3">
                                            <label>Người kia</label>
                                        </div>
                                    </div>
                                </div>
                                {
                                    price.dating ? (
                                        <div>
                                            <div className="alert alert-warning">
                                                Lưu ý chi phí tạo cuộc hẹn đôi là <b>{price.dating.couple_dating_price} VND</b><br />
                                            </div>
                                        </div>
                                    ) : null
                                }
                                <div className="form-group text-center">
                                    <button className="btn btn-primary">Hoàn tất</button>
                                </div>
                            </div>
                        </form>
                    </CardWithTitle>
                </main>
                <aside className="col col-xl-5 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                    <CardWithTitle title="BẠN MUỐN HẸN ĐÔI CÙNG">
                        <Link to={`/profile/${invitee.id}`}>
                            <div className="author vcard inline-items profile-heading-info">
                                <RoundAvatar img={invitee.avatar} size='medium'></RoundAvatar>

                                <div className="author-date">
                                    <Heading heading={invitee.name} subHeading={invitee.address} size='medium'></Heading>
                                </div>
                            </div>
                        </Link>
                    </CardWithTitle>
                </aside>
                <Modal isOpen={this.state.isOpenSuccess}>
                    <h5>Bạn đã gửi lời mời hẹn đôi thành công</h5>
                    <hr />
                    <button className="float-right btn btn-primary" onClick={() => this.closeAlert()}>
                        Xong
                    </button>
                </Modal>
            </div >
        );
    }
}

function mapStateToProps(state) {
    return {
        provinces: state.address.provinces,
        districts: state.address.districts,
        cafes: state.cafe.cafes,
        price: state.payment.price,
        user: state.user.current_user
    }
}

function mapDispatchToProps(dispatch) {
    return {
        getAllProvinces: () => dispatch(getAllProvinces()),
        getAllDistricts: (province_id) => dispatch(getAllDistricts(province_id)),
        getAllCafe: (filter) => dispatch(getAllCafe(filter)),
        createCoupleEvent: (data) => dispatch(createCoupleEvent(data))
    }
}

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(CreateCoupleDating));