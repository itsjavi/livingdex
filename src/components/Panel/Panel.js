import React from 'react';
import styles from './Panel.module.css';
import PropTypes from "prop-types";

function Panel(props) {
    return (
        <div className={styles.panel}>
            <div className={styles.panelHeader}>
                {props.header}
            </div>
            <div className={styles.panelBody}>
                {props.children}
            </div>
        </div>
    );
}

Panel.propTypes = {
    header: PropTypes.any
}

export default Panel
export {Panel}
