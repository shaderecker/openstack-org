/**
 * Copyright 2017 OpenStack Foundation
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 **/
import React from 'react';
import { RawHTML } from '~core-components/rawhtml';
import { connect } from 'react-redux';
import {
    pullScheduleByViewType
} from '../../actions';
import { AjaxLoader } from '~core-components/ajaxloader';

class FullScheduleView extends React.Component {

    constructor(props){
        super(props);
        this.state = {
           showDescription: false
        };
        this.handleChangeShowDesc = this.handleChangeShowDesc.bind(this);
        this.changeCurrentView    = this.changeCurrentView.bind(this);
    }

    changeCurrentView(e){
        let newCurrentView = e.target.value;
        this.props.pullScheduleByViewType(newCurrentView, this.props.summitId);
    }

    handleChangeShowDesc(e){
        this.setState({...this.state, showDescription: e.target.checked});
    }

    goBack(ev) {
        ev.preventDefault();
        window.history.back();
    }

    render(){
        const { events, base_url, should_show_venues, isLoggedUser, backUrl, pdfUrl, goBack } = this.props;
        return (
            <div className="row">
                <AjaxLoader show={ this.props.loading } size={ 120 }/>
                <div className="row schedule-title-wrapper">
                    <div className="col-sm-5 col-main-title">
                        <h1 style={{textAlign:'left'}}>Full Schedule</h1>
                        { goBack &&
                            <div className="go-back">
                                <a href="#" onClick={this.goBack}>&lt;&lt;Go&nbsp;back</a>
                            </div>
                        }
                    </div>
                    <div className="col-sm-2 col-log-in">
                        { isLoggedUser ?
                            (<a title="logout" className="action btn btn-default" id="login-button" href={"/Security/logout/?BackURL="+backUrl}><i className="fa fa-sign-out" aria-hidden="true"></i>Log Out</a>):
                            (<a title="Log in to create your own Schedule and Watch List" className="action btn btn-default" id="login-button" href={"Security/login?BackURL="+backUrl}><i className="fa fa-user"></i>Log in</a>)
                        }
                    </div>
                    <div className="col-sm-5">
                        <form action={pdfUrl}>
                            <button type="submit" className="btn btn-primary export_schedule" >Export PDF</button>
                            <select id="full-schedule-filter" onChange={this.changeCurrentView} defaultValue={this.props.currentView} name="sort">
                                <option value="day">Sort By Day</option>
                                <option value="track">Sort By Track</option>
                                <option value="event_type">Sort By Event Type</option>
                            </select>
                            <label className="btn btn-default" id="show_desc">
                                <input onChange={this.handleChangeShowDesc} type="checkbox" autoComplete={false} name="show_desc"/>Show&nbsp;Description
                            </label>
                        </form>
                    </div>
                </div>
                <hr/>
                {
                    Object.keys(events).map((currentKey, index) => (
                        <div key={index} className="panel panel-default">
                            <div className="panel-heading">{ currentKey }</div>
                            <table className="table">
                                <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Event</th>
                                    <th>Room</th>
                                    <th>RSVP</th>
                                </tr>
                                </thead>
                                <tbody>
                                {events[currentKey].map((event, index) => (
                                    <tr key={event.id} data-id={ event.id }>
                                        <td>{ event.start_time } - { event.end_time } ({event.date_utc})</td>
                                        <td>
                                            <a href={ base_url+'events/'+ event.id } target="_blank">{ event.title }</a><br/>
                                            { this.state.showDescription &&
                                                <div className="event_description">
                                                    <RawHTML>{event.description }</RawHTML>
                                                </div>
                                            }
                                        </td>
                                        {
                                            (should_show_venues) ? (<td>{ event.room }</td>) : (<td>TBD</td>)
                                        }
                                        <td>
                                            { (event.rsvp != '') && <a href={ event.rsvp }>RSVP</a>}
                                            { (event.rsvp == '') && <span> - </span>}
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                        </div>
                    ))
                }
            </div>);
    }
}



function mapStateToProps(state) {
    return {
        events   : state.schedule.events,
        loading  : state.schedule.loading,
    }
}

export default connect(mapStateToProps, {
    pullScheduleByViewType,
})(FullScheduleView)