import React from 'react';
import PropTypes from 'prop-types';
import styles from './Button.module.css';
import {UpperCaseFirst} from "../../app/utils";

function Button(props) {
  let icon = null;
  let className = styles.button;

  if (props.icon) {
    icon = <i className={styles.buttonIcon}>
      {props.icon}
    </i>;
  }
  if (props.type) {
    let typeClassName = "button" + UpperCaseFirst(props.type);
    className += " " + styles[typeClassName];
  }
  if (props.href) {
    return <a rel="noreferrer nofollow" target={props.target} href={props.href} role="button"
              className={className}>{icon}{props.children}</a>
  }
  return (
    <div role="button" className={className}>
      {icon}
      {props.children}
    </div>
  );
}

Button.propTypes = {
  icon: PropTypes.string,
  type: PropTypes.string,
  href: PropTypes.string,
  target: PropTypes.string
}

export {Button};
